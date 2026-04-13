<?php

if (session_status() === PHP_SESSION_NONE)
    session_start();

define('TPL', ROOT . 'view/templates/');
define('COMPONENTS', ROOT . 'view/templates/components/');
define('SCREENS', ROOT . 'view/templates/screens/');

require_once ROOT . 'controller/AuthController.php';
require_once ROOT . 'model/UserModel.php';

class App
{
    private function launchAuth(string $name)
    {
        $auth = new AuthController(COMPONENTS . 'form/form.tpl');
        $auth->run($name);
    }

    public function run(string $page)
    {
        $_SESSION['errorForm'] = '';

        $authPages = ['login', 'signin', 'update-user', 'update-email', 'update-pass'];

        if (in_array($page, $authPages))
        {
            $this->launchAuth($page);
            return;
        }
        echo 'Page not found: ' . $page;
    }
}