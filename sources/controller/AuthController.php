<?php

require_once ROOT . 'validation/FormValidation.php';
require_once ROOT . 'view/View.php';

class AuthController
{
    private View    $view;

    public function __construct(string $file)
    {
        $this->view = new View($file);
    }

    private function sendError()
    {
        header('Location: /index.php');
        exit();
    }

    public function run(string $name, array $lang)
    {
        $allowed = ['login', 'signin', 'updateUser', 'updateEmail', 'updatePass'];
        if (!in_array($name, $allowed))
            $this->sendError();

        if ($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            $check = new FormValidation($_POST);
            $result = $check->checkForm($name, $lang);
            $success = $result['success'];

            if ($success)
            {
                // Mandar al home
                $_SESSION['error'] = 'bien hecho';
            }
            else
                $_SESSION['error'] = $result['message'];
        }
        $auth = new AuthController(COMPONENTS . 'form/form.tpl');
        $auth->$name($lang);
    }

    private function login(array $lang)
    {
        $vars =
        [
            'title' => 'Camagru | Login',
            'page' => 'login',
            
            'logUser' => $lang['usermail'] ?? null,
            'logPass' => $lang['pass'] ?? null
        ];
        $incs = 
        [
            'formContent' => 'components/form/login.tpl'
        ];

        $this->launch($vars, $incs, $lang);
    }

    private function signin(array $lang)
    {
        $vars =
        [
            'title' => 'Camagru | Signin',
            'page' => 'signin',
            
            'signUser' => $lang['user'] ?? null,
            'signEmail' => $lang['email'] ?? null,
            'signPass' => $lang['pass'] ?? null,
            'signPassRep' => $lang['rep_pass'] ?? null,
            'signTerms' => $lang['term'] ?? null
        ];
        $incs = 
        [
            'formContent' => 'components/form/signin.tpl'
        ];

        $this->launch($vars, $incs, $lang);
    }

    private function updateUser(array $lang)
    {
        $vars =
        [
            'title' => 'Camagru | Update',
            'page' => 'updateUser',
            
            'newUser' => $lang['new_user'] ?? null,
            'newCurrentPass' => $lang['curr_pass'] ?? null
        ];
        $incs = 
        [
            'formContent' => 'components/form/updateUser.tpl'
        ];

        $this->launch($vars, $incs, $lang);
    }

    private function updateEmail(array $lang)
    {
        $vars =
        [
            'title' => 'Camagru | Update',
            'page' => 'updateEmail',
            
            'newEmail' => $lang['new_email'] ?? null,
            'newCurrentPass' => $lang['curr_pass'] ?? null,
        ];
        $incs = 
        [
            'formContent' => 'components/form/updateEmail.tpl'
        ];

        $this->launch($vars, $incs, $lang);
    }

    private function updatePass(array $lang)
    {
        $vars =
        [
            'title' => 'Camagru | Update',
            'page' => 'updatePass',
            
            'newCurrentPass' => $lang['curr_pass'] ?? null,
            'newNewPass' => $lang['new_pass'] ?? null,
            'newPassRep' => $lang['rep_pass'] ?? null,
        ];
        $incs = 
        [
            'formContent' => 'components/form/updatePass.tpl'
        ];

        $this->launch($vars, $incs, $lang);
    }

    private function launch(array $vars, array $incs, array $lang)
    {
        /* Common variables */
        $baseVars =
        [
            'language' => $lang['lang'] ?? null,
            'btnDel' => $lang['del'] ?? null,
            'btnSend' => $lang['send'] ?? null,
            'formMsg' => $_SESSION['error'] ?? null,
            'links' => $this->view->getHeadLinks(['form']),
            'scripts' => $this->view->getHeadScripts(['checkForm'])
        ];

        unset($_SESSION['error']);

        $this->view->addIncludes($incs);
        $this->view->addVariables($vars);
        $this->view->addVariables($baseVars);

        echo $this->view->getHtml();
        exit();
    }
}