<?php

namespace App\Core;

class Router
{
    protected $routes = [
        'GET' => [],
        'POST' => []
    ];

    public static function load($file)
    {
        $router = new static;
        require $file;
        return $router;
    }

    public function get($uri, $controller)
    {
        $this->routes['GET'][$uri] = $controller;
    }

    public function post($uri, $controller)
    {
        $this->routes['POST'][$uri] = $controller;
    }

    public function dispatch($uri, $requestType)
    {
        if (array_key_exists($uri, $this->routes[$requestType])) {
            $handler = $this->routes[$requestType][$uri];

            // If the handler is a string in format "Controller@method"
            if (is_string($handler) && strpos($handler, '@') !== false) {
                return $this->callAction(...explode('@', $handler));
            }

            // If it's an array callable: [ClassName::class, 'method'] or [new Controller(), 'method']
            if (is_array($handler) && count($handler) >= 2) {
                $classOrObject = $handler[0];
                $method = $handler[1];

                if (is_string($classOrObject) && class_exists($classOrObject)) {
                    $controller = new $classOrObject;
                    if (method_exists($controller, $method)) {
                        return $controller->$method();
                    }
                }

                if (is_object($classOrObject) && method_exists($classOrObject, $method)) {
                    return $classOrObject->$method();
                }
            }

            // If it is a closure or any callable
            if (is_callable($handler)) {
                return call_user_func($handler);
            }
        }

        throw new \Exception('No route defined for this URI.');
    }

    protected function callAction($controller, $action)
    {
        $controller = "App\\Controllers\\{$controller}";
        $controller = new $controller;

        if (!method_exists($controller, $action)) {
            throw new \Exception(
                "{$controller} does not respond to the {$action} action."
            );
        }

        return $controller->$action();
    }
}
