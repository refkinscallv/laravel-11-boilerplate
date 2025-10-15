<?php

namespace App\Http\Controllers;

use Illuminate\Http\{
    JsonResponse,
    Response
};

abstract class Controller
{
    public function json(
        bool|object|array $status,
        int $code = 200,
        string $message = '',
        array $data = [],
        array $custom = []
    ): JsonResponse {
        if (is_object($status)) {
            $code = $status->code ?? 200;
            $data = $status->data ?? [];
            $custom = $status->custom ?? [];
            $message = $status->message ?? '';
            $status = $status->status ?? true;
        }

        if (is_array($status)) {
            $code = $status['code'] ?? 200;
            $data = $status['data'] ?? [];
            $custom = $status['custom'] ?? [];
            $message = $status['message'] ?? '';
            $status = $status['status'] ?? true;
        }

        return response()->json([
            'status' => $status,
            'code' => $code,
            'message' => $message,
            'data' => $data,
            'custom' => $custom,
        ], $code);
    }

    public function view(string $view = '', array $data = [], array $headers = [], int $code = 200): Response
    {
        return response()->view($view, $data, $code, $headers);
    }
}
