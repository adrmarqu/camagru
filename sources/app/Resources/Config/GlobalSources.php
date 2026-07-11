<?php

abstract class GlobalSources
{
    public static function globalData(): array
    {
        $path = "/" . Lang::getLang() . "/";
        return
        [
            'lang' => Lang::getLang(),
            'css' =>
            [
                '/app.css',
                '/header.css',
                '/error.css'
            ],
            'scripts' =>
            [
                '/header.js'
            ],
            'pages' =>
            [
                'gallery' => $path . 'gallery',
                'editor' => $path . 'photo-editor',
                'login' => $path . 'login',
                'signin' => $path . 'signin',
                'forgot' => $path . 'forgot-password',
                'verify' => $path . 'verify',
                'reset' => $path . 'reset-password',
                'profile' => $path . 'profile',
                'private' => $path . 'private-gallery',
                'favorite' => $path . 'favorites',
            ],
            'username' => $_SESSION['user']['username'] ?? Lang::t('header.guest')
        ];
    }

    public static function header(): array
    {
        $language = 'header.' . Lang::getLang();
        return
        [
            'logged' => isset($_SESSION['user']),
            'gallery' => Lang::t('header.gallery'),
            'editor' => Lang::t('header.editor'),
            'profile' => Lang::t('header.profile'),
            'private' => Lang::t('header.private'),
            'favorite' => Lang::t('header.favorite'),
            'login' => Lang::t('header.login'),
            'signin' => Lang::t('header.signin'),
            'logout' => Lang::t('header.logout'),
            'en' => Lang::t('header.en'),
            'es' => Lang::t('header.es'),
            'ca' => Lang::t('header.ca'),
            'language' => Lang::t($language)
        ];
    }

    public static function footer(): array
    {
        return
        [
            '' => '',
        ];
    }

    /* Global vars */
    public static function all(): array
    {
        return
        [
            'global' => self::globalData(),
            'header' => self::header()
            /* 'footer' => self::footer() */
        ];
    }
}