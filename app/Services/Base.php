<?php

namespace App\Services;

use App\Utils\Mailer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class Base
{
    public function handler(callable $callback, bool $commit = false, callable $callbackErr = null, mixed $context = null): array
    {
        try {
            DB::beginTransaction();
            $response = $callback();

            if ($commit && is_array($response) && ($response['status'] ?? false)) {
                DB::commit();
            } else {
                DB::rollBack();
            }

            return $response;
        } catch (\Throwable $e) {
            if ($commit) {
                DB::rollBack();
            }

            if (is_callable($callbackErr)) {
                $callbackErr($e, $context);
            }

            if ($e instanceof QueryException) {
                $code = $e->errorInfo[1] ?? null;
                $column = $this->parseColumnFromError($e->errorInfo[2] ?? $e->getMessage());

                Log::error('[DB ERROR] ' . $e->getMessage());

                switch ($code) {
                    case 1062:
                        return $this->json(false, 409, "Duplicate entry for field: {$column}");
                    case 1451:
                        return $this->json(false, 409, "Cannot delete because related {$column} exists");
                    case 1452:
                        return $this->json(false, 400, "Invalid relation, missing related {$column}");
                    case 1048:
                        return $this->json(false, 422, "Field {$column} is required");
                    case 1364:
                        return $this->json(false, 422, "Missing required field: {$column}");
                    case 1054:
                        return $this->json(false, 500, "Unknown column: {$column}");
                    case 1146:
                        return $this->json(false, 500, "Table not found in database");
                    default:
                        return $this->json(false, 500, 'A database error has occurred');
                }
            }

            Log::error('[APP ERROR] ' . $e->getMessage());
            return $this->json(false, 500, 'An internal system error has occurred');
        }
    }

    private function parseColumnFromError(string $message): ?string
    {
        if (preg_match("/for key '([\w\d]+)\.([\w\d_]+)_unique'/i", $message, $matches)) {
            return $matches[2] ?? null;
        }

        if (preg_match("/for key '([\w\d_]+)_unique'/i", $message, $matches)) {
            return $matches[1] ?? null;
        }

        if (preg_match("/Column '(\w+)' cannot be null/", $message, $matches)) {
            return $matches[1] ?? null;
        }

        if (preg_match("/Unknown column '(\w+)'/", $message, $matches)) {
            return $matches[1] ?? null;
        }

        if (preg_match("/FOREIGN KEY \(`?(\w+)`?\)/i", $message, $matches)) {
            return $matches[1] ?? null;
        }

        return null;
    }

    public function json(
        bool $status,
        int $code = 200,
        string $message = '',
        array|object|string $result = [],
        array|object $custom = []
    ): array {
        return [
            'status' => $status,
            'code' => $code,
            'message' => $message,
            'data' => $result,
            'custom' => $custom,
        ];
    }

    public function uploadSingleFile(UploadedFile $file, string $path, ?string $customFileName = null): string|false
    {
        $fileName = $customFileName
            ? $customFileName . '.' . $file->getClientOriginalExtension()
            : $file->getClientOriginalName();

        $stored = $file->storeAs($path, $fileName, config('filesystems.default', 'public'));

        return $stored ? 'storage/' . $stored : false;
    }

    public function uploadUrlFile(string $url, string $path, ?string $customFileName = null, bool $randomName = false): string|false
    {
        $response = Http::get($url);

        if (!$response->successful()) {
            return false;
        }

        $ext = pathinfo(parse_url($url, PHP_URL_PATH), PATHINFO_EXTENSION);

        if (!$ext) {
            $ext = 'jpg';
        }

        if ($randomName) {
            $fileName = uniqid('', true) . '.' . $ext;
        } elseif ($customFileName) {
            $fileName = $customFileName . '.' . $ext;
        } else {
            $basename = basename(parse_url($url, PHP_URL_PATH));
            $fileName = $basename ?: uniqid('', true) . '.' . $ext;
        }

        $stored = Storage::put("public/{$path}/{$fileName}", $response->body());

        return $stored ? "storage/{$path}/{$fileName}" : false;
    }

    public function uploadMultipleFiles(array $files, string $path, ?array $customFileNames = []): array
    {
        $paths = [];

        foreach ($files as $index => $file) {
            $customFileName = $customFileNames[$index] ?? null;

            $fileName = $customFileName
                ? $customFileName . '.' . $file->getClientOriginalExtension()
                : $file->getClientOriginalName();

            $stored = $file->storeAs($path, $fileName, config('filesystems.default', 'public'));

            if ($stored) {
                $paths[] = 'storage/' . $stored;
            }
        }

        return $paths;
    }

    public function deleteFile(?string $relativePath): bool
    {
        if (empty($relativePath) || $relativePath === 'storage/') {
            return false;
        }

        $path = str_starts_with($relativePath, 'storage/')
            ? substr($relativePath, strlen('storage/'))
            : $relativePath;

        return Storage::disk(config('filesystems.default', 'public'))->exists($path) && Storage::disk(config('filesystems.default', 'public'))->delete($path);
    }

    public function deleteMultipleFiles(array $relativePaths): void
    {
        foreach ($relativePaths as $relativePath) {
            $this->deleteFile($relativePath);
        }
    }

    public function upsertHasOne(Model $parent, string $relation, array $data): Model
    {
        $related = $parent->$relation()->getRelated();
        $model = $parent->$relation ?? new $related;

        $model->fill($data);

        if (!$model->exists) {
            if ($parent->getKeyName() === 'token') {
                $model->token = md5(now() . uniqid());
            }

            $foreignKeyName = $parent->$relation()->getForeignKeyName();
            $model->$foreignKeyName = $parent->getAttribute($parent->getKeyName());
        }

        $model->save();
        return $model;
    }

    public function sendMail(string $template = '', array $data = [], array $opts = [])
    {
        return Mailer::send([
            ...$opts,
            'body' => view($template, $data)->render(),
        ]);
    }
}
