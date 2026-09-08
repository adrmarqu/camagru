<?php

final class ViewHelper
{
    private function __construct() {}

    /* <?php ViewHelper::print($username); ?> */
    public static function print(?string $var): void
    {
        echo htmlspecialchars($var ?? '', ENT_QUOTES, 'UTF-8');
    }

    public staic function url(string $page = "gallery"): void
    {
        echo '/' . Lang::getLang() . '/' . $page;
    }
}