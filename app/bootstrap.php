<?php
declare(strict_types=1);

define('ROOT_PATH', dirname(__DIR__));

$configFile = ROOT_PATH . '/config/config.php';
$exampleFile = ROOT_PATH . '/config/config.example.php';
$config = require is_file($configFile) ? $configFile : $exampleFile;
$content = require ROOT_PATH . '/app/site-content.php';

date_default_timezone_set((string) ($config['app']['timezone'] ?? 'Europe/Moscow'));

if (PHP_SAPI !== 'cli' && session_status() !== PHP_SESSION_ACTIVE) {
    $secure = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off');
    session_name('crm_services_session');
    session_set_cookie_params([
        'lifetime' => 0,
        'path' => '/',
        'secure' => $secure,
        'httponly' => true,
        'samesite' => 'Lax',
    ]);
    session_start();
}

require_once ROOT_PATH . '/app/helpers.php';
require_once ROOT_PATH . '/app/Database.php';
require_once ROOT_PATH . '/app/LeadRepository.php';

if (PHP_SAPI !== 'cli' && !headers_sent()) {
    header('X-Content-Type-Options: nosniff');
    header('X-Frame-Options: SAMEORIGIN');
    header('Referrer-Policy: strict-origin-when-cross-origin');
    header('Permissions-Policy: camera=(), microphone=(), geolocation=()');
}

