<?php

class Database
{
    private static ?PDO $instance = null;

    public static function getConnection(): PDO
    {
        if (self::$instance === null)
        {
            try
            {
                self::$instance = new PDO(
                    "pgsql:host=db;port=5432;dbname=camagru",
                    "user",
                    "user"
                );

                self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            }
            catch (PDOException $e)
            {
                die("Error de conexión: " . $e->getMessage());
            }
        }
        return self::$instance;
    }
}