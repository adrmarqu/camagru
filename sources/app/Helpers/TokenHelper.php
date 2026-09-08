<?php

final class TokenHelper
{
    /* Generate a token */
    public static function generateToken(int $length = 32): string
    {
        return bin2hex(random_bytes($length));
    }

    /* Hash token */
    public static function hashToken(string $token): string
    {
        return hash('sha256', $token);
    }

    /* Returns if a token has expired or not */
    public static function isExpired(string $expire): bool
    {
        if (empty($expire)) throw new HttpException(500);

        $expiredDate = new DateTime($expire);
        $now = new DateTime();

        return $now > $expiredDate;
    }
}