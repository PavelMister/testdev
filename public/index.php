<?php

require_once '../autoload.php';


if (array_key_exists('HTTP_X_REQUESTED_WITH', $_SERVER) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest') {
    header('Content-Type: application: json');

    $action = $_GET['action'] ?? '';

    exit;
}



echo "php " . var_dump($_ENV);