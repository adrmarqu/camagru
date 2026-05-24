<?php

$checked = '';
if (isset($_COOKIE['remember']))
    $checked = 'checked';

return
[
    'screen' => '/form.tpl',
    'title' => 'Camagru | Login',

    'links' =>
    [
        'file' => COMPONENTS . '/link.tpl',
        
        'data' => [[ 'filename' => 'form.css' ], ['filename' => 'hola.js']]
    ],

    'scripts' =>
    [
        'file' => COMPONENTS . '/script.tpl',

        'data' => [[ 'filename' => 'checkForm.js' ]]
    ],

    'form_content' =>
    [
        'file' => FORMS . '/login.tpl',

        'data' =>
        [[
            'user' => t('form.usermail'),
            'pass' => t('form.pass'),
            'checked' => $checked,
            'remember' => t('form.remember'),

            'forgot' => t('form.forgot'),
            'sign' => t('form.sign')
        ]]
    ]
];