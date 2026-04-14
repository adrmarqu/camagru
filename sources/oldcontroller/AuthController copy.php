<?php

require_once ROOT . 'validation/FormValidation.php';
require_once ROOT . 'model/UserModel.php';
require_once ROOT . 'controller/UserModel.php';
require_once ROOT . 'view/View.php';

class AuthController
{
    private View    $view;

    public function __construct(string $file)
    {
        $this->view = new View($file);
    }

    private function checkPost(string $name)
    {
        $check = new FormValidation($_POST);
        $result = $check->checkForm($name);

        if ($result['successs'])
        {
            $map =
            [
                'login'
            ];
            $checkdb = new UserModel();
            $checkdb->validate($name)
        }

        $success = $result['success'];

        if ($success)
        {
            $_SESSION['errorForm'] = 'bien hecho';
        }
        else
            $_SESSION['errorForm'] = $result['message'];
    }

    public function run(string $name)
    {
        $map =
        [
            'login' => 'login',
            'signin' => 'signin',
            'update-user' => 'updateUser',
            'update-email' => 'updateEmail',
            'update-pass' => 'updatePass'
        ];
        
        if (!isset($map[$name]))
        {
            echo 'Invalid auth';
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST')
            $this->checkPost($name);
        
        $method = $map[$name];
        $this->$method($name);
    }

    private function login(string $name)
    {
        $vars =
        [
            'title' => 'Camagru | Login',
            
            'logUser' => t('form.usermail'),
            'logPass' => t('form.pass')
        ];
        $incs = 
        [
            'formContent' => 'components/form/login.tpl'
        ];

        $this->launch($vars, $incs, $name);
    }

    private function signin(string $name)
    {
        $vars =
        [
            'title' => 'Camagru | Signin',
            
            'signUser' => t('form.user'),
            'signEmail' => t('form.email'),
            'signPass' => t('form.pass'),
            'signPassRep' => t('form.rep_pass'),
            'signTerms' => t('form.term')
        ];
        $incs = 
        [
            'formContent' => 'components/form/signin.tpl'
        ];

        $this->launch($vars, $incs, $name);
    }

    private function updateUser(string $name)
    {
        $vars =
        [
            'title' => 'Camagru | Update',
            
            'newUser' => t('form.new_user'),
            'newCurrentPass' => t('form.curr_pass')
        ];
        $incs = 
        [
            'formContent' => 'components/form/updateUser.tpl'
        ];

        $this->launch($vars, $incs, $name);
    }

    private function updateEmail(string $name)
    {
        $vars =
        [
            'title' => 'Camagru | Update',
            
            'newEmail' => t('form.new_email'),
            'newCurrentPass' => t('form.curr_pass'),
        ];
        $incs = 
        [
            'formContent' => 'components/form/updateEmail.tpl'
        ];

        $this->launch($vars, $incs, $name);
    }

    private function updatePass(string $name)
    {
        $vars =
        [
            'title' => 'Camagru | Update',
            
            'newCurrentPass' => t('form.curr_pass'),
            'newNewPass' => t('form.new_pass'),
            'newPassRep' => t('form.rep_pass'),
        ];
        $incs = 
        [
            'formContent' => 'components/form/updatePass.tpl'
        ];

        $this->launch($vars, $incs, $name);
    }

    private function launch(array $vars, array $incs, string $name)
    {
        /* Common variables */
        $baseVars =
        [
            'page' => $name,
            'language' => t('lang'),
            'btnDel' => t('form.del'),
            'btnSend' => t('form.send'),
            'formMsg' => $_SESSION['errorForm'],
            'links' => $this->view->getHeadLinks(['form']),
            'scripts' => $this->view->getHeadScripts(['checkForm'])
        ];

        unset($_SESSION['errorForm']);

        $this->view->addIncludes($incs);
        $this->view->addVariables($vars);
        $this->view->addVariables($baseVars);

        echo $this->view->getHtml();
        exit();
    }
}