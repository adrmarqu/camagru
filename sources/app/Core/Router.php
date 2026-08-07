<?php

class Router
{
    private array $allowedLangs = ['en', 'es', 'ca'];
    private string $defaultLang = 'en';
    private string $defaultPage = 'gallery';
    private array $routes = [];

    private string $page;
    private string $queryString = '';

    public function __construct(array $routes)
    {
        $this->routes = $routes;
    }

    public function dispatch(string $requestUri): void
    {
        // Clean path
        $cleanUrl = $this->sanitizePath($requestUri);

        // Change to new url if its different
        if ($cleanUrl !== $requestUri)
            Navigator::redirect($this->page . $this->queryString, 301);

        // Get route
        if (!isset($this->routes[$page]))
            throw new HttpException(404);

        $config = $this->routes[$this->page];
        
        // Middleware
        $security = new MiddleWare();
        $security($config['access'] ?? null, $config['token'] ?? null);

        // Controller
        $this->executeController($config);
    }

    private function executeController(array $config): void
    {
        // Get controller
        $controllerName = $config['controller'];
        if (!class_exists($controllerName))
            throw new HttpException(404);

        // Init controller
        $controller = new $controllerName();

        // Check method
        if (!method_exists($controllerName, '__invoke'))
            throw new HttpException(404);

        // Run __invoke()
        $controller();
    }

    private function sanitizePath(string $uri): string
    {
        // Delete multiple slash at the beginning
        $url = '/' . ltrim($uri, '/');

        // Convert url into an array
        $parsedUrl = parse_url($url);

        // Get path and query
        $path = $parsedUrl['path'] ?? '/';
        $queryString = $parsedUrl['query'] ?? '';

        // Clean multiple slashes
        $cleanPath = preg_replace('#/{2,}#', '/', $path);
        // Clean last slash
        $cleanPath = rtrim($cleanPath, '/');

        // Convert path into an array
        $segments = $cleanPath !== '' ? array_values(array_filter(explode('/', $cleanPath))) : [];

        // Has language
        if (!empty($segments) && in_array($segments[0], $this->allowedLangs))
        {
            $lang = array_shift($segments);
            $page = !empty($segments) ? array_shift($segments) : $this->defaultPage;
        }
        // Do not has language
        else
        {
            $lang = $this->defaultLang;
            $page = !empty($segments) ? array_shift($segments) : $this->defaultPage;
        }

        Lang::setLang($lang);
        $this->page = $page;
        $this->queryString = ($queryString !== '' ? '?' . $queryString : '');

        return "/$lang/$page". $this->queryString;
    }
}
