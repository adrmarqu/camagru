<?php

/* if (session_status() === PHP_SESSION_NONE)
    session_start(); */

define('TPL', ROOT . 'views/tpls/');
define('COMPONENTS', ROOT . 'views/tpls/components/');
define('SCREENS', ROOT . 'views/tpls/screens/');

require_once __DIR__ . '/AuthController.php';
require_once ROOT . 'views/languages/sources.php';

class App
{
    private function sendError()
    {
        header('Location: /index.php');
        exit();
    }   

    private function launchAuth(string $name)
    {
        $allowed = ['login', 'signin', 'updateUser', 'updateEmail', 'updatePass'];
        if (!in_array($name, $allowed))
            $this->sendError();

        global $lang;

        if ($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            $check = new CheckFormController($_POST);
            $msg = $check->checkForm($name, $lang);
        }
        $auth = new AuthController(COMPONENTS . 'form/form.tpl');
        $auth->$name($lang, $msg);
    }

    public function run()
    {
        $page = $_GET['page'] ?? 'login';
        $page = preg_replace('/[^a-zA-Z]/', '', $page);

        switch ($page)
        {
            /* case 'home':
                $home = new View();
                break ; */
            case 'login':
            case 'signin':
            case 'updateUser':
            case 'updateEmail':
            case 'updatePass':
                $this->launchAuth($page);
                break ;
            default: 
                echo 'Page not found';
        }
    }
}