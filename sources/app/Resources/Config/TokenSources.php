<?php

abstract class TokenSources
{
    public static function verify(): array
    {
        return 
        [
            'title' => Lang::t('title.verify'),
            'page' => "/" . Lang::getLang() . "/verify"
        ];
    }

    public static function reset(): array
    {
        return 
        [
            'title' => Lang::t('title.reset'),
            'page' => "/" . Lang::getLang() . "/reset-password"
        ];
    }
}