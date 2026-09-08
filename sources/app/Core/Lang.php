<?php

final class Lang
{
    private static string   $lang = 'en';
    private static array    $langData = [];
    private static bool     $isLoaded = false;

    private function __construct() {}

    public static function setLang(string $locale = 'en'): void
    {
        $path = LANG_PATH . "/$locale.php";
        self::$lang = $locale;

        if (file_exists($path)) self::$langData = require $path;
        else self::$langData = require LANG_PATH . "/en.php";

        self::$isLoaded = true;

        $_SESSION['lang'] = $locale;
    }

    public static function t(string $key): string
    {
        if (self::$isLoaded === false) return $key;

        $keys = explode('.', $key);
        $data = self::$langData;

        foreach ($keys as $part)
        {
            if (is_array($data) && isset($data[$part]))
                $data = $data[$part];
            else
                return $key;
        }

        if (is_array($data)) return $key;

        return (string) $data;
    }

    public static function getLang(): string
    {
        if (self::$lang === 'en' && isset($_SESSION['lang']))
            self::$lang = $_SESSION['lang'];
        return self::$lang;
    }
}