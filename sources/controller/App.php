<?php

if (session_status() === PHP_SESSION_NONE)
    session_start();

define('TPL', ROOT . 'view/templates/');
define('COMPONENTS', ROOT . 'view/templates/components/');
define('SCREENS', ROOT . 'view/templates/screens/');

require_once ROOT . 'view/languages/sources.php';
require_once __DIR__ . '/AuthController.php';
require_once ROOT . 'model/UserModel.php';

class App
{
    private function launchAuth(string $name)
    {
        global $lang;

        $auth = new AuthController(COMPONENTS . 'form/form.tpl');
        $auth->run($name, $lang);
    }

    public function run()
    {
        $_SESSION['error'] = '';
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