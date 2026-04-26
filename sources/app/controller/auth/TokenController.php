<?php

require_once BACKEND . 'base/BaseController.php';

class TokenController extends BaseController
{
    private array   $includes = 
    [
        'links' => 
        [
            'path' => COMPONENTS . 'link.tpl',
            'n' => 1,
            'data' => [['filename' => 'form.css']]
        ],
        'scripts' => 
        [
            'path' => COMPONENTS . 'script.tpl',
            'n' => 1,
            'data' => [['filename' => 'checkForm.js']]
        ],
        'form_content' => 
        [
            'path' => FORMS . "verification.tpl",
            'n' => 0,
            'data' => [] 
        ]
    ];

    public function generateTokenAccount()
    {
    }

    public function generateTokenEmail()
    {
    }

    public function checkAccount()
    {
        $this->render('form.tpl',
        [
            'name' => 'verify-account',
            'verification' => t('form.verification_account'),
            'send_code' => t('form.send_code')
        ], $this->includes);
    }

    public function checkEmail()
    {
        $this->render('form.tpl',
        [
            'name' => 'verify-email',
            'verification' => t('form.verification_email'),
            'send_code' => t('form.send_code')
        ], $this->includes);
    }
}