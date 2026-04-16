<?php

require_once BACKEND . 'controller/auth/AuthController.php';
require_once BACKEND . 'controller/user/UserController.php';

class Router
{
    private array $routes = [];

    public function add($path, $controller, $method)
    {
        $this->routes[$path] = [$controller, $method];
    }

    public function resolve($path)
    {
        if (!isset($this->routes[$path]))
        {
            echo '404 - Page not found';
            return;
        }

        [$controller, $method] = $this->routes[$path];

        $instance = new $controller();
        $instance->$method();
    }
}