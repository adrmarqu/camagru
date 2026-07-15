<?php

abstract class AuthSources
{
    public static function login(): array
    {
        return 
        [
            'title' => Lang::t('title.login'),
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

            'scripts_bonus' =>
            [
                '/form.js'
            ]
        ];
    }

    public static function signin(): array
    {
        return 
        [
            'title' => Lang::t('title.signin'),
            'page' => "signin",
            'formTitle' => Lang::t('title.signin'),
            'user' => Lang::t('page.form.user'),
            'userHold' => Lang::t('page.form.placeholder.user'),
            'userErr' => '',
            'email' => Lang::t('page.form.email'),
            'emailHold' => Lang::t('page.form.placeholder.email'),
            'emailErr' => '',
            'pass' => Lang::t('page.form.password'),
            'passHold' => Lang::t('page.form.placeholder.password'),
            'passErr' => '',
            'confirm' => Lang::t('page.form.confirm'),
            'confHold' => Lang::t('page.form.placeholder.confirm'),
            'confirmErr' => '',
            'terms' => Lang::t('page.form.terms'),
            'termsErr' => '',
            'send' => Lang::t('btn.send'),

            'scripts_bonus' =>
            [
                '/form.js'
            ]
        ];
    }

    public static function forgot(): array
    {
        return
        [
            'title' => Lang::t('title.forgot'),
            'page' => "forgot-password",
            'formTitle' => Lang::t('title.forgot'),
            'usermail' => Lang::t('page.form.usermail'),
            'userHold' => Lang::t('page.form.placeholder.usermail'),
            'usermailErr' => '',
            'send' => Lang::t('btn.send'),

            'scripts_bonus' =>
            [
                '/form.js'
            ]
        ];
    }
}