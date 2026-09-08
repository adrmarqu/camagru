<?php

final class Utils
{
    private function __construct() {}

    public static function trim(?string $str): string
    {
        return trim($str ?? '');
    }

    public static function hash(?string $pass): string
    {
        return password_hash($pass, PASSWORD_DEFAULT);
    }

    public static function removeFolder(?string $folder = null): bool
    {
        if (empty($folder))
            $folder = $_SESSION['user']['folder'] ?? null;
        if (empty($folder)) return false;

        $path = PUBLIC_PATH . '/uploads/' . $folder;

        if (!is_dir($path))
            return false;

        rmdir($path);
        return true;
    }
}