<?php

final class UserSources
{
    private function __construct() {}

    public static function profile(): array
    {
        return 
        [
            'title' => 'Camagru | ' . Lang::t('title.profile'),
            'page' => "profile"
        ];
    }

    public static function gallery(): array
    {
        return 
        [
            'title' => 'Camagru | ' . Lang::t('title.private_gallery'),
            'page' => "private-gallery"
        ];
    }

    public static function favorites(): array
    {
        return 
        [
            'title' => 'Camagru | ' . Lang::t('title.favorite'),
            'page' => "favorites"
        ];
    }
}