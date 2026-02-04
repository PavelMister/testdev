<?php

require_once __DIR__ . '/app/Core/Env.php';

\Core\Env::load(__DIR__ . '/.env');

spl_autoload_register(function ($class) {
    $path = __DIR__ . '/app/' . str_replace('\\', '/', $class) . '.php';
    if (file_exists($path)) require $path;
});