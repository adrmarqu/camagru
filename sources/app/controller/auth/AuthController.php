<?php

require_once BACKEND . 'base/BaseController.php';

class AuthController extends BaseController
{
    public function login()
    {
        $error = $this->getFlash($this->name);

        if ($this->isPost())
            $this->load($this->name);

        $this->render('form.tpl',
        [
            'title' => 'Camagru | Login',

            'form_output' => $error,
            'user' => t('form.usermail'),
            'pass' => t('form.pass'),
            'btn_del' => t('form.del'),
            'btn_send' => t('form.send')
        ],
        [
            'links' => 
            [
                'path' => COMPONENTS . 'link.tpl',
                'n' => 1,
                'data' => [['filename' => 'form']]
            ],

            'scripts' => 
            [
                'path' => COMPONENTS . 'script.tpl',
                'n' => 1,
                'data' => [['filename' => 'checkForm']]
            ],

            'form_content' => 
            [
                'path' => FORMS . 'login.tpl',
                'n' => 0,
                'data' => [] 
            ],
        ]);
    }

    public function signin()
    {
        $error = $this->getFlash($this->name);

        if ($this->isPost())
            $this->load($this->name);

        $this->render('form.tpl',
        [
            'title' => 'Camagru | Signin',

            'form_output' => $error,
            'user' => t('form.usermail'),
            'email' => t('form.email'),
            'pass' => t('form.pass'),
            'pass_rep' => t('form.pass_rep'),
            'terms' => t('form.terms'),
            'btn_del' => t('form.del'),
            'btn_send' => t('form.send')
        ],
        [
            'links' => 
            [
                'path' => COMPONENTS . 'link.tpl',
                'n' => 1,
                'data' => [['filename' => 'form']]
            ],

            'scripts' => 
            [
                'path' => COMPONENTS . 'script.tpl',
                'n' => 1,
                'data' => [['filename' => 'checkForm']]
            ],

            'form_content' => 
            [
                'path' => FORMS . 'signin.tpl',
                'n' => 0,
                'data' => [] 
            ],
        ]);
    }
}