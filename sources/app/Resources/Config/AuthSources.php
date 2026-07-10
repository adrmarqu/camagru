<?php

abstract class AuthSources
{
    public static function login(): array
    {
        return 
        [
            'title' => Lang::t('title.login')
        ];
    }

    public static function signin(): array
    {
        return 
        [
            'title' => Lang::t('title.signin')
        ];
    }

    public static function forgot(): array
    {
        return
        [
            'title' => Lang::t('title.forgot')
        ];
    }
}