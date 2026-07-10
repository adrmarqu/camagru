<?php

abstract class LangService
{
    private static $lang = 'en';
    private static $langData = [];

    public static function setLang(string $lang): void
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
        return self::$langData[$key] ?? $key;
    }

    public static function getLang(): string
    {
        return self::$lang ?? 'en';
    }

}