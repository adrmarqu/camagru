<?php

require_once BACKEND . 'controller/BaseController.php';
require_once BACKEND . 'model/code/UserModel.php';
require_once BACKEND . 'model/code/TokenModel.php';

class AuthController extends BaseController
{
    public function login(): void
    {
        $this->name = 'login';
        $error = $this->getFlash($this->name);

        if ($this->isPost())
        {
            $validation = new FormValidation();
            $res = $validation->checkForm($this->name, $_POST);
            
            if ($res['success'] === false)
                $this->reload($this->name, $res['message']);

            $model = new UserModel();
            $result = $model->login($_POST['user'], $_POST['pass']);

            if ($result['success'] === false)
                $this->reload($this->name, $result['message']);

            $_SESSION['user'] =
            [
                'id' => $result['id'],
                'username' => $result['username'],
                'email' => $result['email'],
            ];
            $this->redirect('update-user');
        }

        $this->render(COMPONENTS . 'form/form.tpl',
        [
            'language' => t('lang'),
            'title' => 'Camagru | Login',
            'links' => ['form'],
            'scripts' => ['checkForm'],
            'page' => $this->name,
            'form_output' => $error,
            'btn_del' => t('form.del'),
            'btn_send' => t('form.send'),
            'user' => t('form.usermail'),
            'pass' => t('form.pass'),
        ],
        [
            'form_content' => 'form/login'
        ]);
    }
    
    public function signin(): void
    {
        $this->name = 'signin';
        $error = $this->getFlash($this->name);

        if ($this->isPost())
        {
            $validation = new FormValidation();
            $res = $validation->checkForm($this->name, $_POST);
            
            if ($res['success'] == false)
                $this->reload($this->name, $res['message']);
            
            $model = new UserModel();
            $result = $model->signin($_POST['user'], $_POST['email'], $_POST['pass']);
                
            if ($result['success'] == false)
                $this->reload($this->name, $result['message']);

            $code = new TokenModel();
            $r = $code->generateAccount($result['id'], $result['email']);

            if ($r['success'] == false)
                $this->reload($this->name, $r['message']);

            $_SESSION['user'] =
            [
                'id' => $result['id'],
                'username' => $result['username'],
                'email' => $result['email']
            ];
            $this->redirect('verification');
        }

        $this->render(COMPONENTS . 'form/form.tpl',
        [
            'language' => t('lang'),
            'title' => 'Camagru | Signin',
            'links' => ['form'],
            'scripts' => ['checkForm'],
            'page' => $this->name,
            'form_output' => $error,
            'btn_del' => t('form.del'),
            'btn_send' => t('form.send'),
            'user' => t('form.user'),
            'pass' => t('form.pass'),
            'pass_rep' => t('form.rep_pass'),
            'email' => t('form.email'),
            'terms' => t('form.terms')
        ],
        [
            'form_content' => 'form/signin'
        ]);
    }
}