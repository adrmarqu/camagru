<?php

abstract class Redir
{
    public static function redirect(string $page, $lang = null)
    {
        $lang = $lang ?? LangService::getLang();

        header("Location: /$lang/$page");
        exit;
    }
}