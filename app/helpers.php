<?php
declare(strict_types=1);

function e(mixed $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function money(int|float $value): string
{
    return number_format((float) $value, 0, ',', ' ');
}

function url(string $path = ''): string
{
    global $config;
    $base = rtrim((string) ($config['app']['base_url'] ?? ''), '/');
    return $base . '/' . ltrim($path, '/');
}

function csrf_token(): string
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function verify_csrf(?string $token): bool
{
    return is_string($token) && isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

function redirect(string $path): never
{
    header('Location: ' . $path, true, 303);
    exit;
}

function flash(string $key, mixed $value = null): mixed
{
    if (func_num_args() === 2) {
        $_SESSION['_flash'][$key] = $value;
        return null;
    }
    $stored = $_SESSION['_flash'][$key] ?? null;
    unset($_SESSION['_flash'][$key]);
    return $stored;
}

function old(string $key, string $default = ''): string
{
    $values = $_SESSION['_old_input'] ?? [];
    return (string) ($values[$key] ?? $default);
}

function clear_old_input(): void
{
    unset($_SESSION['_old_input']);
}

function client_ip_hash(): string
{
    global $config;
    $ip = (string) ($_SERVER['REMOTE_ADDR'] ?? 'unknown');
    $key = (string) ($config['app']['key'] ?? 'change-me');
    return hash_hmac('sha256', $ip, $key);
}

function is_admin(): bool
{
    return !empty($_SESSION['admin_authenticated']);
}

function require_admin(): void
{
    if (!is_admin()) {
        redirect('login.php');
    }
}

function status_labels(): array
{
    return [
        'new' => 'Новая',
        'contacted' => 'Связались',
        'demo_sent' => 'Демо отправлено',
        'demo_completed' => 'Демо пройдено',
        'negotiation' => 'Переговоры',
        'prepaid' => 'Предоплата',
        'setup' => 'Настройка',
        'active' => 'Активна',
        'rejected' => 'Отказ',
    ];
}

