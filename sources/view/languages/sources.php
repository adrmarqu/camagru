<?php

function detectLanguage(array $allowed): string
{
    if (!isset($_SERVER['HTTP_ACCEPT_LANGUAGE']))
        return 'en';

    $langs = explode(',', $_SERVER['HTTP_ACCEPT_LANGUAGE']);
    foreach ($langs as $lang)
    {
        $code = strtolower(substr($lang, 0, 2));
        if (in_array($code, $allowed))
            return $code;
    }
    return 'en';
}

function getLanguage(array $allowed): string
{
    $lang = $_GET['lang'] ?? $_COOKIE['lang'] ?? detectLanguage($allowed);

    if (!in_array($lang, $allowed))
        $lang = 'en';
    setcookie('lang', $lang, time() + 3600 * 24 * 30, '/');

    return $lang;
}

$language = getLanguage(['en','ca','es']);

require_once ROOT . 'view/languages/' . $language . '.php';