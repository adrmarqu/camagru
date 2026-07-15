<?php

abstract class Lang
{
    private static $lang = 'en';
    private static $langData = [];

    public static function setLang(string $lang = 'en'): void
    {
        $path = LANG_PATH . "/$lang.php";
        self::$lang = $lang;

        if (file_exists($path))
            self::$langData = require $path;
        else
            self::$langData = require LANG_PATH . "/en.php";
    }

    public static function t(string $key): string
    {
        $keys = explode('.', $key);
        $data = self::$langData;

        foreach ($keys as $part)
        {
            if (isset($data[$part]))
                $data = $data[$part];
            else
                return $key;
        }
        return (string) $data;
    }

    public static function getLang(): string
    {
        if (self::$lang === 'en' && isset($_SESSION['lang']))
            self::$lang = $_SESSION['lang'];
        return self::$lang;
    }
}