<?php

namespace Core;

class Routes
{
    private array $routes = [];


    /**
     * Register GET requests
     * @param $uri
     * @param $callback
     * @return void
     */
    public function get($uri, $callback): void
    {
        $this->routes['GET'][$uri] = $callback;
    }

    /**
     * Register POST requests
     * @param $uri
     * @param $callback
     * @return void
     */
    public function post($uri, $callback): void
    {
        $this->routes['POST'][$uri] = $callback;
    }

    public function resolve(): void
    {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $method = $_SERVER['REQUEST_METHOD'];

        $uri = trim($uri, '/');
        if ($uri === '') $uri = '/';

        if (!isset($this->routes[$method][$uri])) {
            ApiResponse::error('Route not found');
            return;
        }

        $callback = $this->routes[$method][$uri];

        // Call controller and method
        if (is_array($callback)) {
            $controller = new $callback[0]();
            $result = call_user_func([$controller, $callback[1]]);

            if (is_array($result) || is_object($result)) {
                try {
                    ApiResponse::success(call_user_func([$controller, $callback[0]]), $result);
                } catch (\Exception $e) {
                    ApiResponse::error($e->getMessage());
                } finally {
                    exit;
                }
            }

            echo $result;
        }
    }
}