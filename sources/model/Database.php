<?php

class Database
{
    private static ?PDO $db = null;

    public static function connect(): PDO
    {
        if (self::$db === null)
        {
            $host = 'db'; // 👈 docker service
            $dbname = 'camagru';
            $user = 'user';
            $pass = 'user';

            $dsn = "pgsql:host=$host;dbname=$dbname";

            self::$db = new PDO($dsn, $user, $pass, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]);
        }

        return self::$db;
    }
}