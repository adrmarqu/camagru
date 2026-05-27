<?php

return
[
    'file' => '/form.tpl',
    'title' => 'Camagru | Login',

    'links' =>
    [
        'file' => COMPONENTS . '/link.tpl',
        'data' => [[ 'filename' => 'form.css?v=1' ]]
    ],

    'scripts' =>
    [
        'file' => COMPONENTS . '/script.tpl',
        'data' => [[ 'filename' => 'checkForm.js?v=1' ]]
    ],

    'form_title' => t('form.title.login'),
    'form_text' => t('form.text.login'),

    'form_content' => 
    [
        'file' => FORMS . '/login.tpl',

        'data' =>
        [[
            'usermail' => t('form.usermail'),
            'pass' => t('form.pass'),
            'remember_user' => t('form.remember'),

            'forgot_pass' => t('form.forgot'),
        ]]
    ],

    'cancel' => t('form.cancel'),
    'send' => t('form.send')
];