<?php

require_once ROOT . 'controller/BaseController.php';
require_once ROOT . 'validation/FormValidation.php';

class AuthController extends BaseController
{
    public function login(): void
    {
        $error = '';

        if ($this->isPost())
        {
            if (!empty($_POST['user']) && !empty($_POST['pass']))
            {
                $model = new UserModel();
                $result = $model->login($_SESSION['user']['id'], $_POST['user'], $_POST['pass']);

                if ($result['success'])
                {
                    $_SESSION['user'] = [
                        'id' => $result['id'],
                        'username' => $result['username'],
                        'email' => $result['email']
                    ];
                    $this->redirect('/' . t('lang') . '/home');
                }
                $error = $result['message'] ?? 'Error';
            }
            else
                $error = 'Campos vacíos';
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
            if ($this->isSignPostValid($_POST))
            {
                $user = $_POST['user'];
                $email = $_POST['email'];
                $pass = $_POST['pass'];
                $passRep = $_POST['passRep'];
                $terms = $_POST['terms'];

                $validation = new FormValidation();
                $error = $validation->checkSignin($user, $email, $pass, $passRep, $terms);
                
                if ($error === '')
                {
                    $model = new UserModel();
                    $result = $model->signin($_SESSION['user']['id'], $user, $email, $pass);
                    
                    if ($result['success'])
                        $this->redirect('/' . t('lang') . '/home');
                    $error = $result['message'] ?? 'Error';
                }
            }
            else
                $error = 'Campos vacios en el form';   
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