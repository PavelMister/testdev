<?php

require_once '../autoload.php';

$requestUrl = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$urlSegments = explode('/', trim($requestUrl));

var_dump($urlSegments);
// API Routes
if (count($urlSegments) > 2 && $urlSegments[1] === 'api') {
    $action = $urlSegments[2];
    $apiResource = $urlSegments[1];

    return match ($action) {
        'users' => new Controllers\UsersController($action),
        empty($action) => throw new Exception('empty action'),
        default => json_encode([
            'success' => false,
            'message' => 'Undefined api resource'
        ]),
    };

    exit;
}

// Default view for user table
