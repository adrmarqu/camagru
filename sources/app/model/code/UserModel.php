<?php

require_once BACKEND . 'model/BaseModel.php';

class UserModel extends BaseModel
{
    private function getLoginSql(string $usermail): string
    {
        if (filter_var($usermail, FILTER_VALIDATE_EMAIL))
            return "SELECT * FROM users WHERE email = :value";
        return "SELECT * FROM users WHERE username = :value";
    }

    public function login(string $usermail, string $pass): array
    {
        $sql = $this->getLoginSql($usermail);

        try
        {
            $user = $this->getFetch($sql, ['value' => $usermail]);

            /* User no exists */
            if (!$user)
                return $this->ret(false, t('errors.bbdd.user_noexist'));

            /* User no verified */
            if (!$user['is_verified'])
                    return $this->ret(false, t('errors.bbdd.ver'));
            
            /* Wrong password */
            if (!password_verify($pass, $user['password_hash']))
                    return $this->ret(false, t('errors.bbdd.pass'));
            
            return $this->ret(true, '', $user['id'], $user['username'], $user['email']);
        }
        catch (PDOException $e)
        {
            return $this->ret(false, $e->getMessage());
        }
    }

    public function signin(string $user, string $email, string $pass): array
    {
        try
        {
            if ($this->userExists($user) || $this->emailExists($email))
                return $this->ret(false, t('errors.bbdd.no'));

            $hash = password_hash($pass, PASSWORD_DEFAULT);
            $this->execute(
                "INSERT INTO users (username, email, password_hash, is_verified) VALUES (:user, :email, :pass, :ver)", 
                
                ['user' => $user, 'email' => $email, 'pass' => $hash, 'ver' => 0]
            );

            return $this->ret(true, '', $this->pdo->lastInsertId(), $user, $email);
        }
        catch (PDOException $e)
        {
            return $this->ret(false, $e->getMessage());
        }
    }

    public function delete(int $id, string $user, string $email): array
    {
        try
        {
            $stmt = $this->execute(
                "DELETE FROM users WHERE id = :id AND username = :user AND email = :email",

                ['id' => $id, 'user' => $user, 'email' => $email]
            );

            if ($stmt->rowCount() > 0)
            {
                // Borrar cookies aqui

                if (session_status() === PHP_SESSION_ACTIVE)
                    session_destroy();

                return $this->ret(true);
            }
            return $this->ret(false, t('erros.bbdd.delete_no'));
        }
        catch (PDOException $e)
        {
            return $this->ret(false, $e->getMessage());
        }
    }
}