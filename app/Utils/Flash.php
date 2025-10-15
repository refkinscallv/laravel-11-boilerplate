<?php

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Facades\Session;

if (!function_exists('flash')) {
    function flash(string|array|Arrayable $key, mixed $value = null): void
    {
        if ($key instanceof Arrayable) {
            $key = $key->toArray();
        }

        if (is_array($key)) {
            foreach ($key as $k => $v) {
                Session::flash('flash_' . $k, $v);
            }
            return;
        }

        Session::flash('flash_' . $key, $value);
    }
}

if (!function_exists('flash_get')) {
    function flash_get(string $key, mixed $default = null): mixed
    {
        return session()->get('flash_' . $key, $default);
    }
}

if (!function_exists('flash_has')) {
    function flash_has(string $key): bool
    {
        return session()->has('flash_' . $key);
    }
}

if (!function_exists('flash_all')) {
    function flash_all(): array
    {
        return collect(session()->all())
            ->filter(fn($_, $key) => str_starts_with($key, 'flash_'))
            ->mapWithKeys(fn($value, $key) => [str_replace('flash_', '', $key) => $value])
            ->toArray();
    }
}

if (!function_exists('flash_remove')) {
    function flash_remove(string $key): void
    {
        session()->forget('flash_' . $key);
    }
}

if (!function_exists('flash_clear')) {
    function flash_clear(): void
    {
        foreach (session()->all() as $key => $value) {
            if (str_starts_with($key, 'flash_')) {
                session()->forget($key);
            }
        }
    }
}
