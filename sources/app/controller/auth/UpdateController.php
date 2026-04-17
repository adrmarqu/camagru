<?php

require_once BACKEND . 'controller/BaseController.php';
require_once BACKEND . 'model/code/UpdateModel.php';

class UpdateController extends BaseController
{
    public function user(): void
    {
        $error = '';

        if ($this->isPost())
        {
            $validation = new FormValidation();
            $res = $validation->checkForm('update-user', $_POST);

            if ($res['success'])
            {
                $model = new UserModel();
                $result = $model->updateUser($_SESSION['user']['id'], $_POST['user']);

                if ($result['success'])
                {
                    $_SESSION['user']['id'] = $result['id'];
                    $_SESSION['user']['username'] = $result['username'];
                    $this->redirect('home');
                }
                $error = $result['message'];
            }
            else
                $error = $res['message'];
        }

        $this->render(COMPONENTS . 'form/form.tpl',
        [
            'language' => t('lang'),
            'title' => 'Camagru | Update User',
            'links' => ['form'],
            'scripts' => ['checkForm'],
            'page' => 'update-user',
            'formMsg' => $error,
            'btnDel' => t('form.del'),
            'btnSend' => t('form.send'),
            'newUser' => t('form.user'),
            'newCurrentPass' => t('form.curr_pass')
        ],
        [
            'formContent' => 'form/updateUser'
        ]);
    }

    public function email(): void
    {
        $error = '';

        if ($this->isPost())
        {
            $validation = new FormValidation();
            $res = $validation->checkForm('update-email', $_POST);

            if ($res['success'])
            {
                $model = new UserModel();
                $result = $model->updateEmail($_SESSION['user']['id'], $_POST['email']);

                if ($result['success'])
                {
                    $_SESSION['user']['id'] = $result['id'];
                    $_SESSION['user']['email'] = $result['email'];
                    $this->redirect('home');
                }
                $error = $result['message'];
            }
            else
                $error = $res['message'];
        }

        $this->render(COMPONENTS . 'form/form.tpl',
        [
            'language' => t('lang'),
            'title' => 'Camagru | Update Email',
            'links' => ['form'],
            'scripts' => ['checkForm'],
            'page' => 'update-email',
            'formMsg' => $error,
            'btnDel' => t('form.del'),
            'btnSend' => t('form.send'),
            'newEmail' => t('form.email'),
            'newCurrentPass' => t('form.curr_pass')
        ],
        [
            'formContent' => 'form/updateEmail'
        ]);
    }

    public function password(): void
    {
        $error = '';

        if ($this->isPost())
        {
            $pass = $_POST['pass'];
            $passRep = $_POST['passRep'];
            $newPass = $_POST['newPass'];

            $validation = new FormValidation();
            $res = $validation->checkForm('update-password', $_POST);

            if ($res['success'])
            {
                $model = new UserModel();
                $result = $model->updatePassword($_SESSION['user']['id'], $_POST['pass'], $_POST['newPass']);

                if ($result['success'])
                    $this->redirect('home');
                
                $error = $result['message'] ?? 'Error';
            }
            else
                $error = $res['message'];
        }

        $this->render(COMPONENTS . 'form/form.tpl',
        [
            'language' => t('lang'),
            'title' => 'Camagru | Update Password',
            'links' => ['form'],
            'scripts' => ['checkForm'],
            'page' => 'update-password',
            'formMsg' => $error,
            'btnDel' => t('form.del'),
            'btnSend' => t('form.send'),
            'newCurrentPass' => t('form.curr_pass'),
            'newNewPass' => t('form.new_pass'),
            'newPassRep' => t('form.rep_pass')
        ],
        [
            'formContent' => 'form/updatePass'
        ]);
    }
}