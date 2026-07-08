<?php

session_start();

require_once __DIR__ . '/../app/bootstrap.php';

// Rememeber me
/* if (!isset($_SESSION['user']) || isset($_COOKIE['remember_me']))
{
    try
    {
        $token = $_COOKIE['remember_me'];
        $user = getUserByToken($token);

        if ($user)
        {
            $_SESSION['user'] =
            [
                'id' = $user['id'],
                'username' = $user['username'],
                'email' = $user['email']
            ];
        }
        else
            setcookie('remember_me', '', time() - 3600, '/');
    }
    catch (PDOException $e)
    {
        setErrorPage(500, $lang['500']);
    }
} */

$router = new Router();
$router->dispatch();