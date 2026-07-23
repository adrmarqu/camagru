<?php

final class AuthSources
{
    private function __construct() {}

    private static function getErrors(): array
    {
        $errors = $_SESSION['errors'] ?? [];
        unset($_SESSION['errors']);
        return $errors;
    }

    private static function getPost(): array
    {
        $post = $_SESSION['post'] ?? [];
        unset($_SESSION['post']);
        return $post;
    }    

    public static function login(): array
    {
        $e = self::getErrors();
        $p = self::getPost();
        return 
        [
            'title' => 'Camagru | ' . Lang::t('title.login'),
            'pageName' => 'login',
            'formTitle' => Lang::t('title.login'),
            /* Form label */
            'usermail' => Lang::t('page.form.usermail'),
            'pass' => Lang::t('page.form.password'),
            'remember' => Lang::t('page.form.remember'),
            /* Form placeholder */
            'userHold' => Lang::t('page.form.placeholder.usermail'),
            'passHold' => Lang::t('page.form.placeholder.password'),
            /* Form error */
            'usermailErr' => $e['usermail'] ?? '',
            'passErr' => $e['password'] ?? '',
            'globalErr' => $e['global'] ?? '',
            /* Form values */
            'usermailVal' => $p['usermail'] ?? '',
            /* Create account */
            'noAccount' => Lang::t('page.form.no_account'),
            'account' => Lang::t('page.form.create'),
            /* Forgot password */
            'forgot' => Lang::t('page.form.forgot'),
            'reset' => Lang::t('page.form.reset'),
            /* Form buttons */
            'send' => Lang::t('btn.send'),
            /* Files */
            'css' => [ '/form.css' ],
            'scripts' => [ '/form.js' ]
        ];
    }

    public static function signin(): array
    {
        $e = self::getErrors();
        $p = self::getPost();
        return 
        [
            'title' => 'Camagru | ' . Lang::t('title.signin'),
            'pageName' => 'signin',
            'formTitle' => Lang::t('title.signin'),
            /* Form label */
            'user' => Lang::t('page.form.user'),
            'email' => Lang::t('page.form.email'),
            'pass' => Lang::t('page.form.password'),
            'confirm' => Lang::t('page.form.confirm'),
            'terms' => Lang::t('page.form.terms'),
            /* Form placeholder */
            'userHold' => Lang::t('page.form.placeholder.user'),
            'emailHold' => Lang::t('page.form.placeholder.email'),
            'passHold' => Lang::t('page.form.placeholder.password'),
            'confHold' => Lang::t('page.form.placeholder.confirm'),
            /* Form errors */
            'userErr' => $e['user'] ?? '',
            'emailErr' => $e['email'] ?? '',
            'passErr' => $e['password'] ?? '',
            'confirmErr' => $e['confirm'] ?? '',
            'termsErr' => $e['terms'] ?? '',
            'globalErr' => $e['global'] ?? '',
            /* Form values */
            'userVal' => $p['user'] ?? '',
            'emailVal' => $p['email'] ?? '',
            'checked' => isset($p['terms']) ? 'checked' : '',
            /* Form buttons */
            'send' => Lang::t('btn.send'),
            /* Footer */
            'yesAccount' => Lang::t('page.form.account'),
            'account' => Lang::t('page.form.login'),
            /* Files */
            'css' => [ '/form.css' ],
            'scripts' => [ '/form.js' ]
        ];
    }

    public static function forgot(): array
    {
        $e = self::getErrors();
        $p = self::getPost();
        return
        [
            'title' => 'Camagru | ' . Lang::t('title.forgot'),
            'pageName' => 'forgot-password',
            'formTitle' => Lang::t('title.forgot'),
            /* Form label */
            'usermail' => Lang::t('page.form.usermail'),
            /* Form placeholder */
            'userHold' => Lang::t('page.form.placeholder.usermail'),
            /* Form errors */
            'usermailErr' => $e['usermail'] ?? '',
            'globalErr' => $e['global'] ?? '',
            /* Form values */
            'usermailVal' => $p['usermail'] ?? '',
            /* Form buttons */
            'send' => Lang::t('btn.send'),
            /* Files */
            'css' => [ '/form.css' ],
            'scripts' => [ '/form.js' ]
        ];
    }
}