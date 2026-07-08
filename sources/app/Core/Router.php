<?php

class Router
{
    private $allowedLangs = ['en', 'es', 'ca'];
    private $defaultLang = 'en';

    public function dispatch()
    {
        $urlPath = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
        $parts = explode('/', $urlPath, 2);

        $currentLang = $parts[0] ?? null;
        $uri = $parts[1] ?? '';

        if (!in_array($currentLang, $this->allowedLangs))
        {
            $newLang = (isset($_GET['lang']) && in_array($_GET['lang'], $this->allowedLangs)) ? $_GET['lang'] : $this->defaultLang;

            $remainingPath = (count($parts) > 1) ? $parts[1] : 'gallery';

            header("Location: /$newUrl/$remainingPath");
            exit;
        }

        if (empty($uri))
        {
            header("Location: /$currentLang/gallery");
            exit;
        }

        $components = parse_url($uri);

        $page = $components['path'] ?? 'gallery';
        $query = $components['query'] ?? '';

        parse_str($query, $queryParams);

        $_SESSION['lang'] = $currentLang;

        $this->route($page, $currentLang, $queryParams);
    }

    private function route($page, $lang, $query)
    {
        $map = 
        [
            'gallery'           => ['controller' => 'GalleryController', 'method' => 'gallery'],
            'photo-editor'      => ['controller' => 'EditorController', 'method' => 'editor'],
            'login'             => ['controller' => 'AuthController', 'method' => 'login'],
            'register'          => ['controller' => 'AuthController', 'method' => 'register'],
            'forgot-password'   => ['controller' => 'AuthController', 'method' => 'forgot'],
            'profile'           => ['controller' => 'UserController', 'method' => 'profile'],
            'private-gallery'   => ['controller' => 'UserController', 'method' => 'privateGallery'],
            'verify'            => ['controller' => 'TokenController', 'method' => 'verify'],
            'reset-password'    => ['controller' => 'TokenController', 'method' => 'reset']
        ];

        if (!isset($map[$page]))
            Response::error404($lang);

        $config = $map[$page];
        $controllerName = $config['controller'];
        $methodName = $config['method'];

        $controller = new $controllerName($lang);
        $controller->$methodName($query);
    }
}
