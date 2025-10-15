<?php

$autoload = __DIR__ . '/vendor/autoload.php';
if (file_exists($autoload)) {
    require $autoload;
} else {
    echo "[ERROR] vendor/autoload.php not found. Run 'composer install' first.\n";
    exit(1);
}

use Illuminate\Support\Str;

date_default_timezone_set('Asia/Jakarta');

// Simple log helper
function logMessage(string $level, string $message): void
{
    $time = date('Y-m-d H:i:s');
    echo "[{$time}] {$level}: {$message}\n";
}

logMessage('INFO', str_repeat('=', 45));
logMessage('INFO', 'Laravel Setup Started');
logMessage('INFO', str_repeat('=', 45));

$envExample = __DIR__ . '/.env.example';
$envPath = __DIR__ . '/.env';

// Step 1 - Ensure .env exists
logMessage('INFO', 'Checking .env file...');
if (!file_exists($envPath)) {
    if (file_exists($envExample)) {
        copy($envExample, $envPath);
        logMessage('INFO', '.env file created from .env.example');
    } else {
        logMessage('ERROR', '.env.example not found. Setup aborted.');
        exit(1);
    }
} else {
    logMessage('INFO', '.env file already exists.');
}

// Step 2 - Load and verify environment keys
$env = file_get_contents($envPath);
$changes = false;

function appendEnv(&$env, $key, $value, $message)
{
    global $changes;
    if (!preg_match("/^{$key}=.+/m", $env)) {
        $env .= "\n{$key}={$value}";
        logMessage('INFO', $message);
        $changes = true;
    }
}

// Generate APP_KEY if missing
if (!preg_match('/^APP_KEY=.+/m', $env)) {
    logMessage('INFO', 'Generating APP_KEY...');
    exec('php artisan key:generate --ansi', $output, $return);
    if ($return === 0) {
        logMessage('INFO', 'APP_KEY successfully generated.');
    } else {
        logMessage('WARN', 'Failed to generate APP_KEY. Please run "php artisan key:generate" manually.');
    }
}

// JWT keys
appendEnv($env, 'JWT_SECRET', Str::random(64), 'JWT_SECRET generated.');
appendEnv($env, 'JWT_ALGO', 'HS256', 'JWT_ALGO set to default HS256.');
appendEnv($env, 'JWT_TTL', '86400', 'JWT_TTL set to 86400 seconds.');

// Common Laravel keys
appendEnv($env, 'APP_ENV', 'local', 'APP_ENV set to local.');
appendEnv($env, 'APP_DEBUG', 'true', 'APP_DEBUG enabled.');
appendEnv($env, 'APP_URL', 'http://localhost', 'APP_URL set to http://localhost.');

// Database defaults (if missing)
appendEnv($env, 'DB_CONNECTION', 'mysql', 'DB_CONNECTION set to mysql.');
appendEnv($env, 'DB_HOST', '127.0.0.1', 'DB_HOST set to 127.0.0.1.');
appendEnv($env, 'DB_PORT', '3306', 'DB_PORT set to 3306.');
appendEnv($env, 'DB_DATABASE', 'laravel', 'DB_DATABASE set to laravel.');
appendEnv($env, 'DB_USERNAME', 'root', 'DB_USERNAME set to root.');
appendEnv($env, 'DB_PASSWORD', '', 'DB_PASSWORD left empty.');

// Mail defaults (if missing)
appendEnv($env, 'MAIL_MAILER', 'smtp', 'MAIL_MAILER set to smtp.');
appendEnv($env, 'MAIL_HOST', 'smtp.mailtrap.io', 'MAIL_HOST set to smtp.mailtrap.io.');
appendEnv($env, 'MAIL_PORT', '2525', 'MAIL_PORT set to 2525.');
appendEnv($env, 'MAIL_USERNAME', 'null', 'MAIL_USERNAME placeholder added.');
appendEnv($env, 'MAIL_PASSWORD', 'null', 'MAIL_PASSWORD placeholder added.');
appendEnv($env, 'MAIL_ENCRYPTION', 'tls', 'MAIL_ENCRYPTION set to tls.');

// Write updated .env if modified
if ($changes) {
    file_put_contents($envPath, trim($env) . "\n");
    logMessage('INFO', '.env file updated with missing keys.');
} else {
    logMessage('INFO', '.env already contains all required keys.');
}

// Step 3 - Storage link
logMessage('INFO', 'Creating storage symbolic link...');
exec('php artisan storage:link', $linkOutput, $linkReturn);
if ($linkReturn === 0) {
    logMessage('INFO', 'Storage link created successfully.');
} else {
    logMessage('WARN', 'Storage link may already exist or failed to create.');
}

// Step 4 - Run migrations
logMessage('INFO', 'Running database migrations...');
exec('php artisan migrate --force', $migrateOutput, $migrateReturn);
if ($migrateReturn === 0) {
    logMessage('INFO', 'Database migration completed.');
} else {
    logMessage('ERROR', 'Database migration failed. Check your .env configuration.');
}

// Step 5 - Run seeders
logMessage('INFO', 'Running database seeders...');
exec('php artisan db:seed --force', $seedOutput, $seedReturn);
if ($seedReturn === 0) {
    logMessage('INFO', 'Database seeding completed.');
} else {
    logMessage('WARN', 'Database seeding skipped or failed.');
}

logMessage('INFO', 'Setup process completed successfully.');
logMessage('INFO', str_repeat('=', 45));
