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

        $folder = trim($folder, "/\\");
        if ($folder === '' || $folder === '.' || $folder === '..') return false;

        $path = PUBLIC_PATH . '/uploads/' . $folder;

        if (!is_dir($path))
            return false;

        return self::deleteTree($path);
    }

    public static function deleteTree(string $dir): bool
    {
        if (!is_dir($dir)) return false;

        $items = @scandir($dir);
        if ($items === false) return false;

        $files = array_diff($items, ['.', '..']);
        foreach ($files as $file)
        {
            $filePath = $dir . DIRECTORY_SEPARATOR . $file;
            if (is_dir($filePath))
            {
                self::deleteTree($filePath);
            }
            else
            {
                @unlink($filePath);
            }
        }

        return @rmdir($dir);
    }
}