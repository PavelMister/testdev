<?php

require_once '../autoload.php';

use Core\Routes;
use Controllers\MainController;
use Controllers\UsersController;

$router = new Routes();

// API routes
$router->get('api/users/list', [UsersController::class, 'list']);

// Index view
$router->get('/', [MainController::class, 'index']);

$router->resolve();
