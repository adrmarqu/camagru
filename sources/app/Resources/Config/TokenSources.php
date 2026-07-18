<?php

final class TokenSources
{
    private function __construct() {}

    public static function verify(): array
    {
        return 
        [
            'title' => 'Camagru | ' . Lang::t('title.verify'),
            'page' => 'verify'
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