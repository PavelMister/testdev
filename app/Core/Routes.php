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

    /**
     * @throws \ReflectionException
     */
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
            $controllerName = new $callback[0]();
            $methodName = $callback[1];
            $controller = new $controllerName();


            $reflection = new \ReflectionMethod($controller, $methodName);
            $params = [];

            // Merge GET and POST data
            $requestData = array_merge($_GET, $_POST);

            foreach ($reflection->getParameters() as $parameter) {
                $name = $parameter->getName();

                if (array_key_exists($name, $requestData)) {
                    $params[] = $requestData[$name];
                } elseif ($parameter->isDefaultValueAvailable()) {
                    $params[] = $parameter->getDefaultValue();
                } else {
                    $params[] = null;
                }
            }

            $result = call_user_func_array([$controller, $methodName], $params);

            if (is_array($result) || is_object($result)) {
                try {
                    ApiResponse::success($result);
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