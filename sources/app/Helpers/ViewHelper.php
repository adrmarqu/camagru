<?php

final class ViewHelper
{
    private function __construct() {}

    /* <?php ViewHelper::print($username); ?> */
    public static function print(?string $var): void
    {
        echo htmlspecialchars($var ?? '', ENT_QUOTES, 'UTF-8');
    }
}