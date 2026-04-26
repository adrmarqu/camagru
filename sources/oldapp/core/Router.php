<?php

class Router
{
    private array   $routes = [];

    public function add($type, $path, $controller, $method)
    {
        $this->routes[$path] = [$type, $controller, $method];
    }

    public function resolve($path)
    {
        if (!isset($this->routes[$path]))
        {
            echo '404 - Page not found';
            return;
        }

        [$type, $controller, $method] = $this->routes[$path];

        $file = BACKEND . "controller/{$type}/{$controller}.php";
        if (file_exists($file))
        {
            require_once $file;

            $instance = new $controller();
            $instance->$method();
        }
        else
        {
            echo '500 - Internal server error';
            return;
        }
    }
}