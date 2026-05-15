<?php

abstract class Validator
{
    private static $errors = [];

    protected static function addError(string $newError): void
    {
        if ($newError !== '') self::$errors[] = $newError;
    }

    protected static function getErrors(): string
    {
        return implode('</br>', self::$errors);
    }

    protected static function user(string $user): string
    {
        if (empty($user))
            return t('e.form.user.empty');
        $len = strlen($user);
        if ($len < 3 || $len > 15)
            return t('e.form.user.len');
        if (!preg_match('/^[a-zA-Z0-9_-]+$/', $user))
            return t('e.form.user.format');
        if (ctype_digit($user[0]))
            return t('e.form.user.num');
        return '';
    }

    protected static function email(string $email): string
    {
        if (empty($email)) return t('e.form.email.empty');
        if (strlen($email) > 255) return t('e.form.email.len');
        if (filter_var($email, FILTER_VALIDATE_EMAIL))
            return t('e.form.email.format');
        return '';
    }

    protected static function pass(string $pass): string
    {
        $pattern = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/';
        $len = strlen($pass);
       
        if ($len < 8 || $len > 72) return t('e.form.pass.len');
        if (!preg_match($pattern, $pass)) return t('e.form.pass.format');
        return '';
    }

    protected static function passRep(string $pass, string $rep): string
    {
        return ($pass === $rep) ? '' : t('e.form.pass.rep');
    }

    protected static function box($box): string
    {
        return isset($box) ? '' : t('e.form.terms');
    }
}