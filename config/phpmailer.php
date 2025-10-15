<?php

return [
    'debug' => env('MAILER_DEBUG', false),
    'credentials' => [
        'host' => env('MAILER_HOST', ''),
        'auth' => env('MAILER_AUTH', true),
        'name' => env('MAILER_NAME', config('app.name')),
        'user' => env('MAILER_USERNAME', ''),
        'pass' => env('MAILER_PASSWORD', ''),
        'secure' => env('MAILER_SECURE', true)
    ]
];
