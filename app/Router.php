<?php 

namespace App;

class Router {
    private static ?Router $instance = null;
    private array $routes;

    private function __construct(){}
    private function __clone(){}

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new Router();
        }
        return self::$instance;
    }

    public function addRoute(string $method, string $path, string $action, string $controller)
    {
        $this->routes[$method][$path]["action"] = $action;
        $this->routes[$method][$path]["controller"] = $controller;
    }

    public function dispatch()
    {
        $method = $_SERVER["REQUEST_METHOD"];
        $path = str_replace(URL_ROOT, "" , $_SERVER["REQUEST_URI"]);
        $path = strtok($path, "?");

        if (isset($this->routes[$method][$path])) {
            $controller = new $this->routes[$method][$path]['controller']();
            $action = $this->routes[$method][$path]['action'];

            $controller->$action();
        } else {
            throw new \Exception('404 - Not Found');
        }
    }
}