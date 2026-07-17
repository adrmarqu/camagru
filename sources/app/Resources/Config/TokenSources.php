<?php

final class TokenSources
{
    private function __construct() {}

    public static function verify(): array
    {
        return 
        [
            'title' => 'Camagru | ' . Lang::t('title.verify'),
            'page' => "verify"
        ];
    }

    public static function reset(): array
    {
        return 
        [
            'title' => 'Camagru | ' . Lang::t('title.reset'),
            'page' => "reset-password"
        ];
    }

    public static function send(): array
    {
        return
        [
            'title' => 'Camagru | ' . Lang::t('title.send'),
            'page' => "send-email",
            'formTitle' => Lang::t('title.send'),
            'email' => Lang::t('page.form.email_block'),
            'globalErr' => '',
            'send' => Lang::t('btn.email'),

            'scripts' =>
            [
                '/form.js'
            ]
        ];
    }
}