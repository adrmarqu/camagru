<?php

abstract class Navigator
{
    public static function redirect(string $page, $lang = null)
    {
        $lang = $lang ?? Lang::getLang();

        header("Location: /$lang/$page");
        exit;
    }
}