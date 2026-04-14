<?php

if (session_status() === PHP_SESSION_NONE)
    session_start();

define('TPL', ROOT . 'view/templates/');
define('COMPONENTS', ROOT . 'view/templates/components/');
define('SCREENS', ROOT . 'view/templates/screens/');

require_once ROOT . 'controller/AuthController.php';

class App
{
    private function launchAuth(string $name)
    {

        $post = new PostController();
        $result = $post->check($name);
        $auth = new AuthController(COMPONENTS . 'form/form.tpl');
        $auth->run($name);
    }

    public function run(string $page)
    {
        $_SESSION['errorForm'] = '';

        $routes =
        [
            'login'         => '',
            'signin'        => '',
            'update-user'   => '',
            'update-email'  => '',
            'update-pass'   => '',
        ];

        $authPages = ['login', 'signin', 'update-user', 'update-email', 'update-pass'];

        if (!in_array($page, $authPages))
        {
            $this->launchAuth($page);
            return;
        }
        switch ($page)
        {
            case 'login':
                break ;
            case 'login':
                break ;
            case 'login':
                break ;
            case 'login':
                break ;
            case 'login':
                break ;
            default:

        }
        echo 'Page not found: ' . $page;
    }
}