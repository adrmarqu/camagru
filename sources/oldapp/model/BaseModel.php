<?php

require_once BACKEND . 'model/Database.php';

class BaseModel
{
    private PDO     $pdo;

    public function __construct()
    {
        $this->pdo = Database::getConnection();
    }

    protected function emailExists(string $email): bool
    {
        $sql = "SELECT email FROM users WHERE email = :email LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['email' => $email]);

        return (bool) $stmt->fetchColumn();
    }

    protected function userExists(string $user): bool
    {
        $sql = "SELECT username FROM users WHERE username = :user LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['user' => $user]);

        return (bool) $stmt->fetchColumn();
    }

    protected function execute(string $sql, array $data): PDOStatement
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($data);

        return $stmt;
    }

    protected function getFetch(string $sql, array $data): array
    {
        $stmt = $this->execute($sql, $data);
            
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    protected function ret(bool $success, string $msg = '', string $id = '', string $user = '', string $email = ''): array
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