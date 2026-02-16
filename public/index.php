<?php

require_once '../autoload.php';

use Controllers\RolesController;
use Core\Routes;
use Controllers\MainController;
use Controllers\UsersController;

$router = new Routes();

// API routes
$router->get('api/roles', [RolesController::class, 'list']);

//CRUD users
$router->get('api/users', [UsersController::class, 'list']);
$router->post('api/users', [UsersController::class, 'update']);
$router->post('api/users/create', [UsersController::class, 'create']);
$router->delete('api/users', [UsersController::class, 'delete']);
$router->get('api/users/search', [UsersController::class, 'search']);

// Index view
$router->get('/', [MainController::class, 'index']);
$router->get('test', [MainController::class, 'test']);

$router->resolve();
