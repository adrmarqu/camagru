<?php

require_once ROOT . 'controller/auth/AuthController.php';

class App
{
    public function run(string $page)
    {
        if (session_status() === PHP_SESSION_NONE)
            session_start();

        switch ($page)
        {
            case 'login':
                $auth = new AuthController();
                $auth->login();
                break ;
            case 'signin':
                $auth = new AuthController();
                $auth->signin();
                break ;
            case 'update-user':
                $auth = new AuthController();
                $auth->updateUser();
                break ;
            case 'update-email':
                $auth = new AuthController();
                $auth->updateEmail();
                break ;
            case 'update-pass':
                $auth = new AuthController();
                $auth->updatePass();
                break ;
            default:
                echo 'Page not found: ' . $page;
        }
    }
}