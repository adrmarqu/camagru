<?php

require_once BACKEND . 'core/Router.php';

class App
{
    public function run(string $page)
    {
        if (session_status() === PHP_SESSION_NONE)
            session_start();

        $router = new Router();

        $routes = require BACKEND . 'core/routes.php';

        foreach ($routes as $path => [$controller, $method])
            $router->add($path, $controller, $method);

        $router->resolve($page);
    }
}