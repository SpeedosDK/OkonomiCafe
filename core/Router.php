<?php

class Router {
    private $routes = [
        'GET' => [],
        'POST' => [],
    ];
    public function get($path, $action) {
        $this->routes['GET'][$path] = $action;
    }
    public function post($path, $action) {
        $this->routes['POST'][$path] = $action;
    }

    public function dispatch() {
        $method = $_SERVER['REQUEST_METHOD'];
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $action = isset($this->routes[$method][$path]) ? $this->routes[$method][$path] : null;
        if (!$action) {
            http_response_code(404);
            echo '404 Not Found';
            return;
        }

        list($controllerName, $methodName) = explode('@', $action);
        require_once __DIR__ . '/../src/controllers/' . $controllerName . '.php';
        $controller = new $controllerName();
        $controller->$methodName();
    }

}
