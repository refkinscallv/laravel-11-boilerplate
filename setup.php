#!/usr/bin/env php
<?php

/**
 * CLI Script: Generate JWT_SECRET key for Laravel automatically
 * -------------------------------------------------------------
 * Usage: php setup.php
 * Will update .env and add a new JWT_SECRET if empty or missing.
 */

function cliEcho($message, $type = 'info')
{
    $colors = [
        'info'    => "\033[34m",
        'success' => "\033[32m",
        'warning' => "\033[33m",
        'error'   => "\033[31m",
        'gray'    => "\033[90m",
    ];

    $reset = "\033[0m";
    $emoji = [
        'info'    => 'ℹ️ ',
        'success' => '✅ ',
        'warning' => '⚠️ ',
        'error'   => '❌ ',
        'gray'    => '...',
    ];

    $color = $colors[$type] ?? '';
    $icon  = $emoji[$type] ?? '';

    echo "{$color}{$icon}  {$message}{$reset}\n";
}

// -----------------------------
// Initial delay before setup
// -----------------------------
cliEcho('⏳ Waiting 3 seconds before setup starts...', 'gray');
sleep(3); // <--- ubah durasi delay di sini
cliEcho('🚀 Starting setup now...', 'info');

// -----------------------------
// Start setup
// -----------------------------
$envPath = __DIR__ . '/.env';

if (!file_exists($envPath)) {
    cliEcho('File .env not found.', 'error');
    exit(1);
}

cliEcho('Reading .env file...', 'gray');
$env = file_get_contents($envPath);

// --- Check if already has JWT_SECRET
if (preg_match('/^JWT_SECRET=(.+)$/m', $env, $matches) && trim($matches[1]) !== '') {
    cliEcho('JWT_SECRET already exists. Skipped.', 'warning');
} else {
    cliEcho('Generating new JWT secret...', 'info');
    $secret = bin2hex(random_bytes(64));

    if (preg_match('/^JWT_SECRET=.*$/m', $env)) {
        $env = preg_replace('/^JWT_SECRET=.*$/m', "JWT_SECRET={$secret}", $env);
    } else {
        $env .= "\nJWT_SECRET={$secret}\n";
    }

    file_put_contents($envPath, $env);

    cliEcho('JWT_SECRET generated and added to .env', 'success');
    cliEcho("JWT_SECRET = {$secret}", 'gray');
}

cliEcho('Setup completed successfully!', 'success');

// -----------------------------
// Delay + Artisan commands
// -----------------------------
cliEcho('Waiting 2 seconds before running artisan commands...', 'gray');
sleep(2);

cliEcho('Running php artisan key:generate ...', 'info');
passthru('php artisan key:generate');

cliEcho('Running php artisan storage:link ...', 'info');
passthru('php artisan storage:link');

cliEcho('All artisan commands executed successfully!', 'success');
