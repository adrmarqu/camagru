<?php

require_once __DIR__ . '/CheckFormController.php';
require_once ROOT . 'views/View.php';

class AuthController
{
    private View    $view;

    public function __construct(string $file)
    {
        $this->view = new View($file);
    }

    public function login(array $lang, ?string $msg)
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

        $this->launch($vars, $incs, $lang, $msg);
    }

    public function signin(array $lang, ?string $msg)
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

        $this->launch($vars, $incs, $lang, $msg);
    }

    public function updateUser(array $lang, ?string $msg)
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

        $this->launch($vars, $incs, $lang, $msg);
    }

    public function updateEmail(array $lang, ?string $msg)
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

        $this->launch($vars, $incs, $lang, $msg);
    }

    public function updatePass(array $lang, ?string $msg)
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

        $this->launch($vars, $incs, $lang, $msg);
    }

    private function launch(array $vars, array $incs, array $lang, ?string $msg)
    {
        /* Common variables */
        $baseVars =
        [
            'language' => $lang['lang'] ?? null,
            'btnDel' => $lang['del'] ?? null,
            'btnSend' => $lang['send'] ?? null,
            'formMsg' => $msg ?? null,
            'links' => $this->view->getHeadLinks(['form']),
            'scripts' => $this->view->getHeadScripts(['checkForm'])
        ];

        $this->view->addIncludes($incs);
        $this->view->addVariables($vars);
        $this->view->addVariables($baseVars);

        echo $this->view->getHtml();
        exit();
    }
}