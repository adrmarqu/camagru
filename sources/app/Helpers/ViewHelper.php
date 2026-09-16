<?php

final class ViewHelper
{
    private function __construct() {}

    public static function print(?string $var): string
    {
        return htmlspecialchars($var ?? '', ENT_QUOTES, 'UTF-8');
    }

    public static function url(string $page = "gallery"): string
    {
        return '/' . Lang::getLang() . '/' . $page;
    }

    public static function name(?string $name): string
    {
        if (!$name) return '';
        $name = pathinfo($name, PATHINFO_FILENAME);
        return Lang::t("editor.sticker.$name");
    }
}