<?php

require_once BACKEND . 'controller/BaseController.php';
require_once BACKEND . 'model/code/UserModel.php';
require_once BACKEND . 'model/code/CodeModel.php';

class AuthController extends BaseController
{
    public function login(): void
    {
        $error = '';

        if ($this->isPost())
        {
            $validation = new FormValidation();
            $res = $validation->checkForm('login', $_POST);
            
            if ($res['success'])
            {
                $model = new UserModel();
                $result = $model->login($_POST['user'], $_POST['pass']);

                if ($result['success'])
                {
                    $_SESSION['user'] =
                    [
                        'id' => $result['id'],
                        'username' => $result['username'],
                        'email' => $result['email'],
                    ];
                    $this->redirect('signin');
                }
                $error = $result['message'];
            }
            else
                $error = $res['message'];
        }

        $this->render(COMPONENTS . 'form/form.tpl',
        [
            'language' => t('lang'),
            'title' => 'Camagru | Login',
            'links' => ['form'],
            'scripts' => '',
            'page' => 'login',
            'formMsg' => $error,
            'btnDel' => t('form.del'),
            'btnSend' => t('form.send'),
            'logUser' => t('form.usermail'),
            'logPass' => t('form.pass'),
        ],
        [
            'formContent' => 'form/login'
        ]);
    }
    
    private function isSignPostValid(array $post): bool
    {
        return (!empty($post['user']) && !empty($post['email'])
            && !empty($post['pass']) && !empty($post['passRep'])
            && !empty($post['terms']));
    }

    public function signin(): void
    {
        $error = '';

        if ($this->isPost())
        {
            $validation = new FormValidation();
            $res = $validation->checkForm('signin', $_POST);
            
            if ($res['success'])
            {
                $model = new UserModel();
                $result = $model->signin($_POST['user'], $_POST['email'], $_POST['pass']);
                
                if ($result['success'])
                {
                    $code = new CodeModel();
                    $r = $code->setVerificationCode($result['id']);

                    if ($r['success'])
                    {
                        $_SESSION['user'] =
                        [
                            'id' => $result['id'],
                            'username' => $result['username'],
                            'email' => $result['email']
                        ];
                        $this->redirect('verification');
                    }
                    $error = $r['message'];
                }
                $error = $result['message'];
            }
            else
                $error = $res['message'];
        }

        $this->render(COMPONENTS . 'form/form.tpl',
        [
            'language' => t('lang'),
            'title' => 'Camagru | Signin',
            'links' => ['form'],
            'scripts' => ['checkForm'],
            'page' => 'signin',
            'formMsg' => $error,
            'btnDel' => t('form.del'),
            'btnSend' => t('form.send'),
            'signUser' => t('form.user'),
            'signPass' => t('form.pass'),
            'signPassRep' => t('form.rep_pass'),
            'signEmail' => t('form.email'),
            'signTerms' => t('form.terms')
        ],
        [
            'formContent' => 'form/signin'
        ]);
    }
}