<?php

final class Utils
{
    private function __construct() {}

    public static function trim(?string $str): string
    {
        return trim($str ?? '');
    }
}