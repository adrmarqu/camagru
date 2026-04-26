<?php

class Router
{
    private array   $routes = [];

    public function add($path, $dir, $controller, $method)
    {
        $this->routes[$path] = [$dir, $controller, $method];
    }

    public function resolve($path)
    {
        if (!isset($this->routes[$path]))
        {
            echo '404 - Page not found';
            return;
        }

        [$dir, $controller, $method] = $this->routes[$path];

        $file = BACKEND . "controller/{$dir}/{$controller}.php";
        if (file_exists($file))
        {
            require_once $file;
   
            $instance = new $controller($path);
            $instance->$method();
        }
        else
        {
            echo '500 - Internal server error';
            return;
        }
    }
}