<?php

abstract class TokenSources
{
    public static function verify(): array
    {
        return 
        [
            'title' => Lang::t('title.verify'),
            'page' => "verify"
        ];
    }

    public static function reset(): array
    {
        return 
        [
            'title' => Lang::t('title.reset'),
            'page' => "reset-password"
        ];
    }
}