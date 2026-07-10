<?php

// Quitar al final
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

// Load configuration and autoloader
require_once __DIR__ . '/../app/bootstrap.php';

// Remember me
if (!isset($_SESSION['user']) && isset($_COOKIE['remember_me']))
    AuthService::loginWithCookie($_COOKIE['remember_me']);

// Main
try
{
    $paths = require CONF_PATH . '/routes.php';
    
    $router = new Router($paths);
    $router->dispatch();
}
catch (AppException $e) 
{
    $error = new ErrorController();
    $error->display($e);
}