<?php

final class TokenHelper
{
    public static function generateToken(): string
    {
        return bin2hex(random_bytes(32));
    }
}