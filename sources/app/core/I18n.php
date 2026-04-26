<?php

abstract class I18n
{
    private static array    $texts = [];
    private static string   $lang;

    public static function init(array $allowed, string $default = 'en'): void
    {
        $selected = $_GET['lang'] ?? $_COOKIE['lang'] ?? self::detect($allowed) ?? $default;
        
        if (!in_array($selected, $allowed))
            $selected = $default;

        if (($_COOKIE['lang'] ?? '') !== $selected)
        {
            setcookie('lang', $selected, time() + (3600 * 24 * 30), '/', '', false, true);
        }
        self::load($selected);
    }

    private static function detect(array $allowed): ?string
    {
        if (!isset($_SERVER['HTTP_ACCEPT_LANGUAGE']))
            return null;

        preg_match_all('/([a-z]{2})/i', $_SERVER['HTTP_ACCEPT_LANGUAGE'], $matches);
        
        foreach ($matches[1] as $code)
            if (in_array(strtolower($code), $allowed))
                return strtolower($code);
        return null;
    }

    public static function load(string $lang): void
    {
        self::$lang = $lang;

        $path = BACKEND . "language/langs/{$lang}.php";
        if (file_exists($path))
            self::$texts = require $path;
    }

    public static function getLanguage(): string
    {
        return self::$lang;
    }

    public static function getText(string $key): string
    {
        $keys = explode('.', $key);
        $value = self::$texts;

        foreach ($keys as $k)
        {
            if (!isset($value[$k]))
                return $key;
            $value = $value[$k];
        }

        return (string)$value;
    }
}

function t(string $key): string
{
    return I18n::getText($key);
}