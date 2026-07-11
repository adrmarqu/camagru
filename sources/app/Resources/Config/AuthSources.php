<?php

abstract class AuthSources
{
    public static function login(): array
    {
        return 
        [
            'title' => Lang::t('title.login'),
            'page' => "/" . Lang::getLang() . "/login",
            'formTitle' => Lang::t('title.login'),
            'usermail' => Lang::t('page.form.usermail'),
            'usermailErr' => '',
            'pass' => Lang::t('page.form.pass'),
            'passErr' => '',
            'remember' => Lang::t('page.form.remember'),
            'noAccount' => Lang::t('page.form.no_account'),
            'account' => Lang::t('page.form.create')
        ];
    }

    public static function signin(): array
    {
        return 
        [
            'title' => Lang::t('title.signin'),
            'page' => "/" . Lang::getLang() . "/signin"
        ];
    }

    public static function forgot(): array
    {
        return
        [
            'title' => Lang::t('title.forgot'),
            'page' => "/" . Lang::getLang() . "/forgot-password"
        ];
    }
}