<?php

require_once BACKEND . 'model/BaseModel.php';

class UserModel extends BaseModel
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
            if (!$user) // Select = 0
                return $this->makeReturn(false, t('errors.bbdd.user_noexist'));

            if (!password_verify($pass, $user['password_hash']))
                return $this->makeReturn(false, t('errors.bbdd.pass'));

            if (!$user['is_verified'])
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
            
            $stmt = $pdo->prepare("INSERT INTO users (username, email, password_hash, is_verified) VALUES (:user, :email, :pass, :ver)");

            $stmt->execute(['user' => $user, 'email' => $email, 'pass' => $hash, 'ver' => 0]);

            return $this->makeReturn(true, '', $pdo->lastInsertId(), $user, $email);
        }
        catch (PDOException $e)
        {
            return $this->makeReturn(false, $e->getMessage());
        }
    }
}