<?php

final class Validate
{
    private function __construct() {}

    public static function empty(string $var): bool
    {
        return empty($var);
    }

    public static function usermail(string $user): bool
    {
        return (strpos($user, '@') !== false) 
            ? self::user($user) 
            : self::email($user);
    }

    public static function user(string $user): bool
    {
        // Check length
        $length = strlen($user);
        if ($length < 3 || $length > 20)
            return false;
        // Check format
        if (!preg_match('/^[a-zA-Z][a-zA-Z0-9_-]+$/', $user))
            return false;
        return true;
    }

    public static function email(string $email): bool
    {
        // Check size
        if (strlen($email) > 255)
            return false;
        // Check format
        if (filter_var($email, FILTER_VALIDATE_EMAIL) === false)
            return false;
        return true;
    }

    public static function pass(string $pass): bool
    {
        // Check length - 8-72
        $length = strlen($pass);
        if ($length < 8 || $length > 72)
            return false;
        // Check format - 1lower - 1upper - 1digit
        if (!preg_match('/[a-z]/', $pass)
            || !preg_match('/[A-Z]/', $pass)
            || !preg_match('/[0-9]/', $pass))
            return false;
        return true;
    }

    public static function confirm(string $pass, string $confirm): bool
    {
        return $pass === $confirm;
    }
}