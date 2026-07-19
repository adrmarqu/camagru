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
    AuthHelper::loginWithCookie($_COOKIE['remember_me']);

// Main
try
{
    $paths = require CONF_PATH . '/routes.php';
    
    $router = new Router($paths);
    $router->dispatch();
}
/* App exception */
catch (AppException $e) 
{
    $error = new ErrorController();
    $error->display($e);
}
/* Database exception */
catch (PDOException $e)
{
    /* Check if there are a transaction */
    try
    {
        $db = Database::getConn();

        if ($db && $db->inTransaction()) 
            $db->rollback();
    } 
    catch (Throwable $dbError) {}

    $exception = new AppException(500, $e->getMessage());

    $error = new ErrorController();
    $error->display($exception);
}
/* Unexpected exception */
catch (Exception $e)
{
    $exception = new AppException(500, $e->getMessage());

    $error = new ErrorController();
    $error->display($exception);
}