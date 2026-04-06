<?php

/* function getScripts(array $scripts)
{
    if (empty($scripts))
        return null;

    $ret = "";
    foreach ($scripts as $name)
        $ret .= '<script src="./css/' . $name . '" defer></script>';
    return $ret;
} */

function getLanguage(): string
{
    $allowedLangs = ['en', 'ca', 'es'];
    $lang = $_GET['lang'] ?? $_COOKIE['language'] ?? 'en'; 
    if (!in_array($lang, $allowedLangs))
        $lang = 'en';
    return $lang;
}

function getArrayData(string $title)
{
    $array = 
    [
        'language' => getLanguage(),
        'title' => $title ?? 'camagru',
    ];

    return $array;
}