<?php

final class AuthSources
{
    private function __construct() {}

    public static function login(): array
    {
        return 
        [
            'title' => 'Camagru | ' . Lang::t('title.login'),
            'page' => "login",
            'formTitle' => Lang::t('title.login'),
            'usermail' => Lang::t('page.form.usermail'),
            'userHold' => Lang::t('page.form.placeholder.usermail'),
            'usermailErr' => '',
            'pass' => Lang::t('page.form.password'),
            'passHold' => Lang::t('page.form.placeholder.password'),
            'passErr' => '',
            'remember' => Lang::t('page.form.remember'),
            'noAccount' => Lang::t('page.form.no_account'),
            'account' => Lang::t('page.form.create'),
            'send' => Lang::t('btn.send'),
            'forgot' => Lang::t('page.form.forgot'),
            'reset' => Lang::t('page.form.reset'),
            'globalErr' => $e['global'] ?? '',

            'scripts' =>
            [
                '/form.js'
            ]
        ];
    }

    public static function signin(array $e): array
    {
        return 
        [
            'title' => 'Camagru | ' . Lang::t('title.signin'),
            'page' => "signin",
            'formTitle' => Lang::t('title.signin'),
            'user' => Lang::t('page.form.user'),
            'userHold' => Lang::t('page.form.placeholder.user'),
            'userErr' => $e['user'] ?? '',
            'email' => Lang::t('page.form.email'),
            'emailHold' => Lang::t('page.form.placeholder.email'),
            'emailErr' => $e['email'] ?? '',
            'pass' => Lang::t('page.form.password'),
            'passHold' => Lang::t('page.form.placeholder.password'),
            'passErr' => $e['pass'] ?? '',
            'confirm' => Lang::t('page.form.confirm'),
            'confHold' => Lang::t('page.form.placeholder.confirm'),
            'confirmErr' => $e['conf'] ?? '',
            'terms' => Lang::t('page.form.terms'),
            'termsErr' => $e['terms'] ?? '',
            'send' => Lang::t('btn.send'),
            'globalErr' => $e['global'] ?? '',

            'scripts' =>
            [
                '/form.js'
            ]
        ];
    }

    public static function forgot(): array
    {
        return
        [
            'title' => 'Camagru | ' . Lang::t('title.forgot'),
            'page' => "forgot-password",
            'formTitle' => Lang::t('title.forgot'),
            'usermail' => Lang::t('page.form.usermail'),
            'userHold' => Lang::t('page.form.placeholder.usermail'),
            'usermailErr' => '',
            'send' => Lang::t('btn.send'),
            'globalErr' => $e['global'] ?? '',

            'scripts' =>
            [
                '/form.js'
            ]
        ];
    }
}