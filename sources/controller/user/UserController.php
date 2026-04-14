<?php

require_once ROOT . 'controller/BaseController.php';
require_once ROOT . 'validation/FormValidation.php';

class UserController extends BaseController
{
    public function user(): void
    {
        $error = '';

        if ($this->isPost())
        {
            if (!empty($_POST['user']))
            {
                $user = $_POST['user'];

                $validation = new FormValidation();
                $error = $validation->checkUser($user);

                if ($error === '')
                {
                    $model = new UserModel();
                    $result = $model->updateUser($_SESSION['user']['id'],$user);

                    if ($result['success'])
                    {
                        $_SESSION['user']['username'] = $result['username'];
                        $this->redirect('/' . t('lang') . '/home');
                    }
                    $error = $result['message'] ?? 'Error';
                }
            }
            else
                $error = 'Campos vacíos';
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
            if (!empty($_POST['email']))
            {
                $email = $_POST['email'];

                $validation = new FormValidation();
                $error = $validation->checkEmail($email);

                if ($error === '')
                {
                    $model = new UserModel();
                    $result = $model->updateEmail($_SESSION['user']['id'], $email);

                    if ($result['success'])
                    {
                        $_SESSION['user']['email'] = $result['email'];
                        $this->redirect('/' . t('lang') . '/home');
                    }
                    $error = $result['message'] ?? 'Error';
                }
            }
            else
                $error = 'Campos vacíos';
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
            if (!empty($_POST['pass']) && !empty($_POST['newPass']) && !empty($_POST['passRep']))
            {
                $pass = $_POST['pass'];
                $passRep = $_POST['passRep'];
                $newPass = $_POST['newPass'];

                $validation = new FormValidation();
                $error = $validation->checkPass($newPass);
                if ($error === '')
                    $error = $validation->checkPassRep($newPass, $passRep);

                if ($error === '')
                {
                    $model = new UserModel();
                    $result = $model->updatePassword($_SESSION['user']['id'], $pass, $newPass);

                    if ($result['success'])
                    {
                        $this->redirect('/' . t('lang') . '/home');
                    }
                    $error = $result['message'] ?? 'Error';
                }
            }
            else
                $error = 'Campos vacíos';
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