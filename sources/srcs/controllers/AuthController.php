<?php

require_once ROOT . 'views/View.php';

class AuthController
{
    private array   $incs = [];
    private array   $vars = [];
    private View    $view;

    public function __construct(string $file)
    {
        $this->view = new View($file);
    }

    public function login(array $lang)
    {
        $this->incs = 
        [
            'formContent' => 'components/form/login.tpl'
        ];
        $this->vars =
        [
            'title' => 'Camagru | Login',
            'page' => 'login',
            'type' => 'login',
            
            'logUser' => $lang['usermail'],
            'logPass' => $lang['pass']
        ];

        $this->launch($lang);
    }

    public function signin(array $lang)
    {
        $this->incs = 
        [
            'formContent' => 'components/form/signin.tpl'
        ];
        $this->vars =
        [
            'title' => 'Camagru | Signin',
            'page' => 'signin',
            'type' => 'signin',
            
            'signUser' => $lang['user'],
            'signEmail' => $lang['email'],
            'signPass' => $lang['pass'],
            'signPassRep' => $lang['new_pass'],
            'signTerms' => $lang['term']
        ];

        $this->launch($lang);
    }

    public function update(array $lang, string $option)
    {
        switch ($option)
        {
            case 'user':
                $file = 'components/form/updateUser.tpl';
                $user = $lang['new_user'];
                $id = 'updateUser';
                break ;
            case 'email':
                $file = 'components/form/updateEmail.tpl';
                $email = $lang['new_email'];
                $id = 'updateEmail';
                break ;
            case 'pass':
                $file = 'components/form/updatePass.tpl';
                $newPass = $lang['new_pass'];
                $repPass = $lang['rep_pass'];
                $id = 'updatePass';
                break ;
            default:
                header('Location: /index.php');
                exit();
        }

        $this->incs = 
        [
            'formContent' => $file
        ];
        $this->vars =
        [
            'title' => 'Camagru | Update',
            'page' => 'update&upd_opt=' . $option,
            'type' => $id,
            
            'newUser' => $user ?? null,
            'newEmail' => $email ?? null,
            'newCurrentPass' => $lang['curr_pass'],
            'newNewPass' => $newPass ?? null,
            'newPassRep' => $repPass ?? null
        ];

        $this->launch($lang);
    }

    private function launch(array $lang)
    {
        $css = ['form'];

        /* Common variables */
        $baseVars =
        [
            'language' => $lang['lang'],
            'btnDel' => $lang['del'],
            'btnSend' => $lang['send'],
            'css' => $this->view->getCss($css) ?? null
        ];

        $this->view->addIncludes($this->incs);
        $this->view->addVariables($this->vars);
        $this->view->addVariables($baseVars);

        echo $this->view->getHtml();
        exit();
    }
}