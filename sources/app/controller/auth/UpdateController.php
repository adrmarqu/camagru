<?php

require_once BACKEND . 'base/BaseController.php';

class UpdateController extends BaseController
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
    ];

    public function user()
    {
        $form =
        [
            'form_content' =>
            [
                'path' => FORMS . "updateUser.tpl",
                'n' => 0,
                'data' => [] 
            ]
        ];

        $this->render('form.tpl',
        [
            'user' => t('form.new.user'),
            'pass' => t('form.current.pass')
        ], array_merge($this->includes, $form));
    }

    public function email()
    {
        $form =
        [
            'form_content' =>
            [
                'path' => FORMS . "updateEmail.tpl",
                'n' => 0,
                'data' => [] 
            ]
        ];

        $this->render('form.tpl',
        [
            'email' => t('form.new.email'),
            'pass' => t('form.current.pass')
        ], array_merge($this->includes, $form));
    }

    public function password()
    {
        $form =
        [
            'form_content' =>
            [
                'path' => FORMS . "updatePass.tpl",
                'n' => 0,
                'data' => [] 
            ]
        ];

        $this->render('form.tpl',
        [
            'current' => t('form.current.pass'),
            'new' => t('form.new.pass'),
            'rep' => t('form.pass_rep')
        ], array_merge($this->includes, $form));
    }
}