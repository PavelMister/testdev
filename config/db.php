<?php

return [
    'db' => [
        'host'    => $_ENV['DB_HOST'] ?? 'empty_host',
        'dbname'  => $_ENV['DB_NAME'] ?? 'empty_db_name',
        'user'    => $_ENV['DB_USER'] ?? 'empty_username',
        'pass'    => $_ENV['DB_PASS'] ?? 'empty_pass',
        'charset' => $_ENV['DB_CHARSET'] ?? 'utf8mb4'
    ],
];
