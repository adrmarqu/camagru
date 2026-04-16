<?php

require_once BACKEND . 'model/Database.php';

class UserModel
{
    public function login(string $usermail, string $pass): array
    {
        try
        {
            $pdo = Database::getConnection();

            if (filter_var($usermail, FILTER_VALIDATE_EMAIL))
                $sql = "SELECT * FROM users WHERE email = :value";
            else
                $sql = "SELECT * FROM users WHERE username = :value";

            $stmt = $pdo->prepare($sql);

            $stmt->execute(['value' => $usermail]);

            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!$user)
                return $this->makeReturn(false, t('errors.bbdd.usermail'));

            if (!password_verify($pass, $user['password_hash']))
                return $this->makeReturn(false, t('errors.bbdd.pass'));

            if (!$user['verified'])
                return $this->makeReturn(false, t('errors.bbdd.ver'));

            return $this->makeReturn(true, '', $user['id'], $user['username'], $user['email']);
        }
        catch (PDOException $e)
        {
            return $this->makeReturn(false, $e->getMessage());
        }
    }

    public function signin(string $user, string $email, string $pass): array
    {
        try
        {
            $pdo = Database::getConnection();

            if ($this->userExists($pdo, $user))
                return $this->makeReturn(false, t('errors.bbdd.rep_user'));

            if ($this->userExists($pdo, $email))
                return $this->makeReturn(false, t('errors.bbdd.rep_email'));

            $hash = password_hash($pass, PASSWORD_DEFAULT);
            
            $stmt = $pdo->prepare("INSERT INTO users (username, email, password_hash, verified) VALUES (:user, :email, :pass, :ver)");

            $stmt->execute(['user' => $user, 'email' => $email, 'pass' => $hash, 'ver' => 0]);

            return $this->makeReturn(true, '', $pdo->lastInsertId(), $user, $email);
        }
        catch (PDOException $e)
        {
            return $this->makeReturn(false, $e->getMessage());
        }
    }

    public function updateUser(int $id, string $newuser): array
    {
        try
        {
            $pdo = Database::getConnection();
            
            if ($this->userExists($pdo, $newuser))
                return $this->makeReturn(false, t('errors.bbdd.rep_user'));

            $stmt = $pdo->prepare("UPDATE users SET username = :user WHERE id = :id");

            $stmt->execute(['user' => $newuser, 'id' => $id]);

            if ($stmt->rowCount() > 0)
                return $this->makeReturn(true, '', $id);
            
            return $this->makeReturn(false, t('errors.bbdd.update'));
        }
        catch (PDOException $e)
        {
            return $this->makeReturn(false, $e->getMessage());
        }
    }

    public function updateEmail(int $id, string $newemail): array
    {
        try
        {
            $pdo = Database::getConnection();
            
            if ($this->userExists($pdo, $newemail))
                return $this->makeReturn(false, t('errors.bbdd.rep_email'));

            $stmt = $pdo->prepare("UPDATE users SET email = :email WHERE id = :id");

            $stmt->execute(['email' => $newemail, 'id' => $id]);

            if ($stmt->rowCount() > 0)
                return $this->makeReturn(true, '', $id);
            
            return $this->makeReturn(false, t('errors.bbdd.update'));
        }
        catch (PDOException $e)
        {
            return $this->makeReturn(false, $e->getMessage());
        }
    }

    public function updatePass(int $id, string $checkpass, string $newpass): array
    {
        try
        {
            $pdo = Database::getConnection();

            if ($this->samePass($pdo, $id, $checkpass))
                return $this->makeReturn(false, t('errors.bbdd.rep_pass'));
            
            $stmt = $pdo->prepare("UPDATE users SET password_hash = :pass WHERE id = :id");

            $hash = password_hash($newpass, PASSWORD_DEFAULT);
            $stmt->execute(['pass' => $hash, 'id' => $id]);

            if ($stmt->rowCount() > 0)
                return $this->makeReturn(true, '', $id);
            
            return $this->makeReturn(false, t('errors.bbdd.update'));
        }
        catch (PDOException $e)
        {
            return $this->makeReturn(false, $e->getMessage());
        }
    }

    private function samePass(PDO $pdo, int $id, string $pass): bool
    {
        $stmt = $pdo->prepare("SELECT password_hash FROM users WHERE id = :id LIMIT 1");

        $stmt->execute(['id' => $id]);

        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$user)
            return false;
        
        $hash = password_hash($pass, PASSWORD_DEFAULT);

        return password_verify($hash, $user['password_hash']);
    }

    private function userExists(PDO $pdo, string $user): bool
    {
        $stmt = $pdo->prepare("SELECT 1 FROM users WHERE username = :value OR email = :value LIMIT 1");

        $stmt->execute(['value' => $user]);

        return (bool) $stmt->fetchColumn();
    }

    private function makeReturn(bool $success, string $msg = '', string $id = '', string $user = '', string $email = ''): array
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