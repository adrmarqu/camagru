<?php

if (session_status() === PHP_SESSION_NONE)
    session_start();

define('TPL', ROOT . 'views/tpls/');                   /* views/tpls */
define('COMPONENTS', ROOT . 'views/tpls/components/'); /* tpls/components */
define('SCREENS', ROOT . 'views/tpls/screens/');       /* tpls/screens */

require_once __DIR__ . '/AuthController.php';
require_once ROOT . 'views/languages/sources.php';

class App
{
    public function run()
    {
        global $lang;
        $page = $_GET['page'] ?? 'login';
        $page = preg_replace('/[^a-z]/', '', $page);

        switch ($page)
        {
            /* case 'home':
                $home = new View();
                break ; */
            case 'login':
                $auth = new AuthController(COMPONENTS . 'form/form.tpl');
                $auth->login($lang);
                break ;
            case 'signin':
                $auth = new AuthController(COMPONENTS . 'form/form.tpl');
                $auth->signin($lang);
                break ;
            case 'update':
                $opt = $_GET['upd_opt'] ?? '';
                if (empty($opt))
                {
                    header('Location: /index.php');
                    exit();
                }
                $auth = new AuthController(COMPONENTS . 'form/form.tpl');
                $auth->update($lang, $opt);
                break ;
            default: 
                echo "Page not found";
        }
    }
}