<?php

// Quitar al final
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

// Load configuration and autoloader
require_once __DIR__ . '/../app/Core/bootstrap.php';

try
{
    Auth::loginWithCookie();
    
    $paths = require CORE_PATH . '/routes.php';
    
    $router = new Router($paths);
    $router->dispatch($_SERVER['REQUEST_URI']);
}
/* Display the error in a container */
/* catch (DBException $e)
{

} */
/* Display a error page */
catch (HttpException $e)
{
    $error = new HttpController();
    $error($e);
}
/* Others -> Display a 500 error page */
catch (Throwable $e)
{
    $exception = new HttpException(500, $e->getMessage());

    $error = new HttpController();
    $error($exception);
}