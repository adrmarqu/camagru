<?php

abstract class AuthSources extends BaseSources
{
    public static function login(): array
    {
        return 
        [
            'lang' => self::t('lang'),
            'title' => self::t('title.login')
        ];
    }

    public static function signin(): array
    {
        return 
        [
            'lang' => self::t('lang'),
            'title' => self::t('title.signin')
        ];
    }
}