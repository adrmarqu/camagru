<?php

require_once 'Database.php';

class UserModel
{
    public static function existsUsername(string $username): bool
    {
        $db = Database::connect();

        $stmt = $db->prepare("
            SELECT 1 
            FROM users 
            WHERE username = :username 
            LIMIT 1
        ");

        $stmt->execute([
            'username' => $username
        ]);

        return (bool) $stmt->fetchColumn();
    }

    public static function existsEmail(string $email): bool
    {
        $db = Database::connect();

        $stmt = $db->prepare("
            SELECT 1 
            FROM users 
            WHERE email = :email 
            LIMIT 1
        ");

        $stmt->execute([
            'email' => $email
        ]);

        return (bool) $stmt->fetchColumn();
    }
}