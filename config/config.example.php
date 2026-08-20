<?php
declare(strict_types=1);

return [
    'app' => [
        'env' => 'production',
        'base_url' => 'https://example.ru',
        'timezone' => 'Europe/Moscow',
        'key' => 'REPLACE_WITH_A_LONG_RANDOM_SECRET',
    ],
    'database' => [
        'host' => 'localhost',
        'port' => 3306,
        'name' => 'crm_for_services',
        'user' => 'crm_user',
        'password' => 'REPLACE_WITH_DATABASE_PASSWORD',
        'charset' => 'utf8mb4',
    ],
    'admin' => [
        'username' => 'admin',
        'password_hash' => 'REPLACE_WITH_PASSWORD_HASH',
    ],
    'LEAD_NOTIFY_WEBHOOK_URL' => '',
];
