<?php

require_once BACKEND . 'controller/BaseController.php';
require_once BACKEND . 'model/code/UpdateModel.php';

class UpdateController extends BaseController
{
    public function user(): void
    {
        $this->name = 'update-user';
        $error = $this->getFlash($this->name);

        if ($this->isPost())
        {
            $validation = new FormValidation();
            $res = $validation->checkForm('update-user', $_POST);

            if ($res['success'] === false)
                $this->reload($this->name, $res['message']);
            
            $model = new UserModel();
            $result = $model->updateUser($_SESSION['user']['id'], $_POST['user']);
            
            if ($result['success'] === false)
                $this->reload($this->name, $result['message']);
            
            $_SESSION['user']['id'] = $result['id'];
            $_SESSION['user']['username'] = $result['username'];
            
            $this->redirect('home');
        }

        $this->render(COMPONENTS . 'form/form.tpl',
        [
            'language' => t('lang'),
            'title' => 'Camagru | Update User',
            'links' => ['form'],
            'scripts' => ['checkForm'],
            'page' => $this->name,
            'form_output' => $error,
            'btn_del' => t('form.del'),
            'btn_send' => t('form.send'),
            'new_user' => t('form.user'),
            'current_pass' => t('form.curr_pass')
        ],
        [
            'form_content' => 'form/updateUser'
        ]);
    }

    public function email(): void
    {
        $this->name = 'update-email';
        $error = $this->getFlash($this->name);

        if ($this->isPost())
        {
            $validation = new FormValidation();
            $res = $validation->checkForm('update-email', $_POST);
            if ($res['success'] === false)
                $this->reload($this->name, $res['message']);

            $model = new UpdateModel();
            $result = $model->emailToken($_SESSION['user']['id'], $_POST['email']);
            
            if ($result['success'] === false)
                $this->reload($this->name, $result['message']);
            
            $_SESSION['user']['id'] = $result['id'];
            $_SESSION['user']['email'] = $result['email'];
            
            $this->redirect('home');
        }

        $this->render(COMPONENTS . 'form/form.tpl',
        [
            'language' => t('lang'),
            'title' => 'Camagru | Update Email',
            'links' => ['form'],
            'scripts' => ['checkForm'],
            'page' => $this->name,
            'form_output' => $error,
            'btn_del' => t('form.del'),
            'btn_send' => t('form.send'),
            'new_email' => t('form.email'),
            'current_pass' => t('form.curr_pass')
        ],
        [
            'form_content' => 'form/updateEmail'
        ]);
    }

    public function password(): void
    {
        $this->name = 'update-password';
        $error = $this->getFlash($this->name);

        if ($this->isPost())
        {
            $pass = $_POST['pass'];
            $passRep = $_POST['passRep'];
            $newPass = $_POST['newPass'];

            $validation = new FormValidation();
            $res = $validation->checkForm('update-password', $_POST);
            if ($res['success'] === false)
                $this->reload($this->name, $res['message']);

            $model = new UserModel();
            $result = $model->updatePassword($_SESSION['user']['id'], $_POST['pass'], $_POST['newPass']);
            
            if ($result['success'] === false)
                $this->reload($this->name, $result['message']);
                    
            $this->redirect('home');
        }

        $this->render(COMPONENTS . 'form/form.tpl',
        [
            'language' => t('lang'),
            'title' => 'Camagru | Update Password',
            'links' => ['form'],
            'scripts' => ['checkForm'],
            'page' => $this->name,
            'form_output' => $error,
            'btn_del' => t('form.del'),
            'btn_send' => t('form.send'),
            'current_pass' => t('form.curr_pass'),
            'new_pass' => t('form.new_pass'),
            'new_pass_rep' => t('form.rep_pass')
        ],
        [
            'form_content' => 'form/updatePass'
        ]);
    }
}