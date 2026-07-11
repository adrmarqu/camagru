<?php

abstract class UserSources
{
    public static function profile(): array
    {
        return 
        [
            'title' => Lang::t('title.profile'),
            'page' => "/" . Lang::getLang() . "/profile"
        ];
    }

    public static function gallery(): array
    {
        return 
        [
            'title' => Lang::t('title.private_gallery'),
            'page' => "/" . Lang::getLang() . "/private-gallery"
        ];
    }
}