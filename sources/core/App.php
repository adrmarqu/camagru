<?php

define('COMPONENTS', ROOT . 'view/templates/components/');

require_once ROOT . 'core/Router.php';

class App
{
    public function run(string $page)
    {
        if (session_status() === PHP_SESSION_NONE)
            session_start();

        $router = new Router();

        $routes = require ROOT . 'core/routes.php';

        foreach ($routes as $path => [$controller, $method])
            $router->add($path, $controller, $method);

        $router->resolve($page);
    }
}