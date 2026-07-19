<?php

class Router
{
    private $allowedLangs = ['en', 'es', 'ca'];
    private $defaultLang = 'en';
    private $routes = [];

    public function __construct(array $routes)
    {
        $this->routes = $routes;
    }

    public function dispatch()
    {
        $urlPath = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
        $parts = explode('/', $urlPath, 2);

        $currentLang = $parts[0] ?? null;
        $uri = $parts[1] ?? '';

        if (!in_array($currentLang, $this->allowedLangs))
        {
            $newLang = (isset($_GET['lang']) && in_array($_GET['lang'], $this->allowedLangs)) ? $_GET['lang'] : $this->defaultLang;
            
            $remainingPath = (count($parts) > 1) ? $parts[1] : (!empty($parts[0]) ? $parts[0] : 'gallery');

            Navigator::redirect($remainingPath, $newLang);
        }

        if (empty($uri))
            Navigator::redirect("gallery", $currentLang);

        $page = $uri;

        $_SESSION['lang'] = $currentLang;
        Lang::setLang($currentLang);

        $this->route($page, $_GET);
    }

    private function route($page, $query)
    {
        /* Check if the page exists */
        if (!isset($this->routes[$page]))
            throw new AppException(404);

        $config = $this->routes[$page];

        /* Check page access */
        $this->checkAccess($config['access'] ?? null);

        $controllerName = $config['controller'];
        $methodName = $config['method'];

        /* Check if the class and method exists */
        if (!class_exists($controllerName))
            throw new AppException(500, Lang::t('500.no_class') . $controllerName);

        $controller = new $controllerName();
        
        if (!method_exists($controller, $methodName))
            throw new AppException(500, Lang::t('500.no_method') . "$controllerName::$methodName");

        $reflection = new ReflectionMethod($controller, $methodName);
        $parameters = $reflection->getParameters();

        /*  */
        if (!empty($parameters)) $controller->$methodName($query);
        else $controller->$methodName();
    }

    private function checkAccess(string $access): void
    {
        if ($access === null)
            throw new AppException(500);

        if ($access === 'public') return ;

        switch ($access)
        {
            case 'guest':
                
                if (isset($_SESSION['user']))
                    Navigator::redirect('gallery');
                
                break ;
            case 'user':
                
                if (!isset($_SESSION['user']))
                    throw new AppException(401, null, '/login');
                
                break ;
            /* Reset-password page */
            case 'token-reset':
                
                
                if (isset($_SESSION['reset_token']))
                    return ;

                if (isset($_SESSION['user']))
                    throw new AppException(403, Lang::t('403.no_token'));
                else
                    throw new AppException(403, Lang::t('403.no_token'), '/login');
                
                break ;
            /* Send-email page */
            case 'token-send':
                
                $sendData = $_SESSION['send_email'] ?? null;

                if (!$sendData)
                    throw new AppException(403, Lang::t('403.no_token'));

                $action = $sendData['action'] ?? null;
                $email  = $sendData['email']  ?? null;
                $token  = $sendData['token']  ?? null;

                if (!$action || !$email || !$token)
                    throw new AppException(403, Lang::t('403.no_token'));

                if ($action === 'account' && isset($_SESSION['user']))
                    throw new AppException(403);

                if ($action === 'email' && !isset($_SESSION['user']))
                    throw new AppException(401, null, '/login');

                break ;
            default:
                throw new AppException(500, Lang::t('500.no_access') . $access);
        }
    }
}
