<?php

final class TokenSources
{
    private function __construct() {}

    /* Result account */
    public static function account(): array
    {
        return 
        [
            'title' => 'Camagru | ' . Lang::t('title.verify_account'),
            'page' => 'verify',
            'titlePage' => Lang::t('email.account.title'),
            'body' => Lang::t('verify.account'),
            'action' => 'account',
            'btnCont' => Lang::t('go.login')
        ];
    }

    /* Result email */
    public static function email(): array
    {
        return 
        [
            'title' => 'Camagru | ' . Lang::t('title.verify_email'),
            'page' => 'verify',
            'titlePage' => Lang::t('email.email.title'),
            'body' => Lang::t('verify.email'),
            'action' => 'email',
            'btnCont' => Lang::t('go.profile')
        ];
    }

    public static function reset(): array
    {
        return 
        [
            'title' => 'Camagru | ' . Lang::t('title.reset'),
            'page' => 'reset-password'
        ];
    }

    public static function send(): array
    {
        return
        [
            'title' => 'Camagru | ' . Lang::t('title.send'),
            'page' => 'send-email',
            'sendTitle' => Lang::t('title.send'),
            'email' => $_SESSION['send_email']['email'],
            'send' => Lang::t('btn.email'),
            'sendBody' => Lang::t('send_body'),
            'scripts' =>
            [
                '/send.js'
            ]
        ];
    }
}