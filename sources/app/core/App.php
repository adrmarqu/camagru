<?php

require_once BACKEND . 'core/I18n.php';
require_once BACKEND . 'core/Router.php';

class App
{
    private array $allowedLangs = ['es', 'ca', 'en'];

    public function __construct()
    {
        I18n::init($this->allowedLangs, 'es');
    }

    public function run()
    {
        if (session_status() === PHP_SESSION_NONE)
            session_start();

        $page = $this->parseUrl();

        $routes = require BACKEND . 'core/routes.php';

        $router = new Router();

        foreach ($routes as $path => [$dir, $controller, $method])
            $router->add($path, $dir, $controller, $method);

        $router->resolve($page);
    }

    private function parseUrl(): string
    {
        $page = $_GET['page'] ?? 'login';
        $page = strtolower($page);
        $page = preg_replace('/[^a-z0-9-\/]/', '', $page);

        $requestPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $requestPath = rtrim($requestPath, '/');

        $canonical = '/' . I18n::getLanguage() . '/' . $page;

        if ($requestPath !== $canonical)
        {
            header('Location: ' . $canonical, true, 301);
            exit();
        }
        return $page;
    }
}