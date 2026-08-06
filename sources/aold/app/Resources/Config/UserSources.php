<?php

final class UserSources
{
    private function __construct() {}

    public static function profile(): array
    {
        return 
        [
            'title' => 'Camagru | ' . Lang::t('title.profile'),
            'page' => 'profile',
            // Titles
            'titlePage' => Lang::t('title.profile'),
            'avatarUrl' => $_SESSION['user']['avatar'] ?? '/assets/default.webp',
            'stats' => Lang::t('profile.title.stats'),
            'info' => Lang::t('profile.title.info'),
            'security' => Lang::t('profile.title.sec'),
            'notification' => Lang::t('profile.title.pref'),
            'deleteTitle' => Lang::t('profile.title.del'),
            'sure' => Lang::t('profile.title.sure'),
            // Labels
            'photosLabel' => Lang::t('profile.photos'),
            'likesLabel' => Lang::t('profile.likes'),
            'commentsLabel' => Lang::t('profile.com'),
            'userText' => Lang::t('profile.label.user'),
            'emailText' => Lang::t('profile.label.email'),
            'passText' => Lang::t('profile.label.pass'),
            'userLabel' => Lang::t('profile.form.user'),
            'emailLabel' => Lang::t('profile.form.email'),
            'passLabel' => Lang::t('profile.form.pass'),
            'newLabel' => Lang::t('profile.form.new'),
            'confLabel' => Lang::t('profile.form.conf'),
            'notiLabel' => Lang::t('profile.form.noti'),
            'deleteText' => Lang::t('profile.delete'),
            'confirmDel' => Lang::t('profile.confirm'),
            // Placeholders
            'passHold' => Lang::t('page.form.placeholder.current'),
            'newHold' => Lang::t('page.form.placeholder.new_password'),
            'confHold' => Lang::t('page.form.placeholder.new_confirm'),
            // Stats - Data
            'nPhotos' => 0,
            'nLikes' => 0,
            'nComments' => 0,
            'username' => $_SESSION['user']['name'] ?? Lang::t(''),
            'email' => $_SESSION['user']['email'] ?? Lang::t(''),
            'checked' => (!isset($_SESSION['user']['notification']) || $_SESSION['user']['notification']) ? 'checked' : '',
            // Buttons
            'avatarBtn' => Lang::t('btn.avatar'),
            'edit' => Lang::t('btn.edit'),
            'cancel' => Lang::t('btn.cancel'),
            'save' => Lang::t('btn.save'),
            'deleteBtn' => Lang::t('btn.account'),
            // files
            'css' =>
            [
                '/forms.css',
                '/profile.css'
            ],
            'scripts' =>
            [
                '/forms.js',
                '/profile/avatar.js',
                '/profile/information.js',
                '/profile/security.js',
                '/profile/preferences.js',
                '/profile/danger.js'
            ]
        ];
    }

    public static function gallery(): array
    {
        return 
        [
            'title' => 'Camagru | ' . Lang::t('title.private_gallery'),
            'page' => 'private-gallery'
        ];
    }

    public static function favorites(): array
    {
        return 
        [
            'title' => 'Camagru | ' . Lang::t('title.favorite'),
            'page' => 'favorites'
        ];
    }
}