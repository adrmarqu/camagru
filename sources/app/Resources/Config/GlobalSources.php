<?php

final class GlobalSources
{
    private function __construct() {}
   
    public static function globalData(): array
    {
        $path = "/" . Lang::getLang() . "/";
        return
        [
            'lang' => Lang::getLang(),
            /* Pages url */
            'galleryUrl' => $path . 'gallery',
            'editorUrl' => $path . 'photo-editor',
            'loginUrl' => $path . 'login',
            'signinUrl' => $path . 'signin',
            'forgotUrl' => $path . 'forgot-password',
            'verifyUrl' => $path . 'verify',
            'resetUrl' => $path . 'reset-password',
            'sendUrl' => $path . 'send-email',
            'profileUrl' => $path . 'profile',
            'privateUrl' => $path . 'private-gallery',
            'favoriteUrl' => $path . 'favorites',
            /* User data */
            'username' => $_SESSION['user']['name'] ?? Lang::t('header.guest')
        ];
    }

    public static function header(): array
    {
        $language = 'header.' . Lang::getLang();
        return
        [
            'logged' => isset($_SESSION['user']),
            /* Nav elements */
            'galleryNav' => Lang::t('header.gallery'),
            'editorNav' => Lang::t('header.editor'),
            'profileNav' => Lang::t('header.profile'),
            'privateNav' => Lang::t('header.private'),
            'favoriteNav' => Lang::t('header.favorite'),
            'loginNav' => Lang::t('header.login'),
            'signinNav' => Lang::t('header.signin'),
            'logoutNav' => Lang::t('header.logout'),
            /* Lang */
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
}