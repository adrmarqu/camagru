<?php

// Quitar al final
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

// Load configuration and autoloader
require_once __DIR__ . '/../app/bootstrap.php';

// Main
try
{
    // Remember me
    if (!isset($_SESSION['user']) && isset($_COOKIE['remember_me']))
    {
        $authentication = new CookieController();
        $authentication->loginWithCookie($_COOKIE['remember_me']);
    }

    $paths = require CONF_PATH . '/routes.php';
    
    $router = new Router($paths);
    $router->dispatch();
}
/* Form exception - Do not display error page */
catch (FormException $e)
{
    $_SESSION['errors'] = $e->getErrors();
    $_SESSION['errors']['global'] = $e->getHttpError();

    Navigator::redirect(AppHelper::getCurrentPage());
}
/* App exception - Display error page */
catch (AppException $e) 
{
    $error = new ErrorController();
    $error->display($e);
}
/* Others - Display error page */
catch (Throwable $e)
{
    $exception = new AppException(500, $e->getMessage());

    $error = new ErrorController();
    $error->display($exception);
}