<?php

abstract class Validator
{
    public static function usermail(string $usermail): ?string
    {
        /* Delete spaces */
        $usermail = trim($usermail);
        /* Detect empty */
        if (empty($usermail))
            return Lang::t('error.empty.usermail');
        /* Decide where to check */
        $isValidFormat = (strpos($usermail, '@') !== false) 
                ? self::email($usermail) 
                : self::user($usermail);
        /* Get generic error message */
        if ($isValidFormat !== null)
            return Lang::t('error.usermail');
        return null;
    }

    public static function user(string $user): ?string
    {
        /* Delete spaces */
        $user = trim($user);
        /* Check empty */
        if (empty($user))
            return Lang::t('error.empty.user');
        /* Check length */
        $length = strlen($user);
        if ($length < 3 || $length > 20)
            return Lang::t('error.length.user');
        /* Check format */
        if (!preg_match('/^[a-zA-Z][a-zA-Z0-9_-]+$/', $user))
            return Lang::t('error.user');
        return null;
    }

    public static function email(string $email): ?string
    {
        /* Delete spaces */
        $email = trim($email);
        /* Detect empty */
        if (empty($email))
            return Lang::t('error.empty.email');
        /* Check size */
        if (strlen($email) > 255)
            return Lang::t('error.length.email');
        /* Check format */
        if (filter_var($email, FILTER_VALIDATE_EMAIL) === false)
            return Lang::t('error.email');
        return null;
    }

    public static function pass(string $pass): ?string
    {
        /* Detect empty */
        if (empty($pass))
            return Lang::t('error.empty.password');
        /* Check length */
        $length = strlen($pass);
        /* Min 8 */
        if ($length < 8)
            return Lang::t('error.length.password_8');
        /* Max 72 */
        if ($length > 72)
            return Lang::t('error.length.password_72');
        /* Check format */
        if (!preg_match('/[a-z]/', $pass)
            || !preg_match('/[A-Z]/', $pass)
            || !preg_match('/[0-9]/', $pass))
            return Lang::t('error.password');
        return null;
    }

    public static function confirm(string $pass, string $confirm): ?string
    {
        /* Detect empty */
        if (empty($confirm))
            return Lang::t('error.empty.confirm');
        /* Check equal */
        if ($pass !== $confirm)
            return Lang::t('error.confirm');
        return null;
    }

    /* public static function (): string
    {
        
    }

    public static function (): string
    {
        
    }

    public static function (): string
    {
        
    } */
}