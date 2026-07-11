<?php

abstract class UserSources
{
    public static function profile(): array
    {
        return 
        [
            'title' => Lang::t('title.profile'),
            'page' => "profile"
        ];
    }

    public static function gallery(): array
    {
        return 
        [
            'title' => Lang::t('title.private_gallery'),
            'page' => "private-gallery"
        ];
    }

    public static function favorites(): array
    {
        return 
        [
            'title' => Lang::t('title.favorite'),
            'page' => "favorites"
        ];
    }
}