<?php

abstract class TokenSources
{
    public static function verify(): array
    {
        return 
        [
            'title' => Lang::t('title.verify')
        ];
    }

    public static function reset(): array
    {
        return 
        [
            'title' => Lang::t('title.reset')
        ];
    }
}