<?php

final class Navigator
{
    private function __construct() {}
    
    public static function redirect(string $page, $lang = null): void
    {
        $lang = $lang ?? Lang::getLang();

        header("Location: /$lang/$page");
        exit;
    }
}