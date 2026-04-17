<?php

require_once BACKEND . 'model/Database.php';

class BaseModel
{
    protected function samePass(PDO $pdo, int $id, string $pass): bool
    {
        $stmt = $pdo->prepare("SELECT password_hash FROM users WHERE id = :id LIMIT 1");

        $stmt->execute(['id' => $id]);

        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$user)
            return false;
        
        $hash = password_hash($pass, PASSWORD_DEFAULT);

        return password_verify($hash, $user['password_hash']);
    }

    protected function userExists(PDO $pdo, string $user): bool
    {
        $stmt = $pdo->prepare("SELECT 1 FROM users WHERE username = :value OR email = :value LIMIT 1");

        $stmt->execute(['value' => $user]);

        return (bool) $stmt->fetchColumn();
    }

    protected function makeReturn(bool $success, string $msg = '', string $id = '', string $user = '', string $email = ''): array
    {
        return
        [
            'id' => $id,
            'username' => $user,
            'email' => $email,
            'success' => $success,
            'message' => $msg
        ];
    }
}