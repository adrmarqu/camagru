<?php

require_once BACKEND . 'model/BaseModel.php';

class UpdateModel extends BaseModel
{
    public function user(int $id, string $user): array
    {
        try
        {
            $stmt = $this->execute("UPDATE users SET username = :user WHERE id = :id ", ['id' => $id, 'user' => $user]);

            if ($stmt->rowCount() > 0)
                return $this->ret(true);
            return $this->ret(false, t('errors.bbdd.no_user'));
        }
        catch (PDOException $e)
        {
            if ($e->errorInfo[0] == '23505')
                return $this->ret(false, t('errors.bbdd.user_exists'));
            return $this->ret(false, $e->getMessage());
        }
    }

    public function email(int $id, string $email): array
    {
        try
        {
            $stmt = $this->execute("UPDATE users SET email = :email WHERE id = :id", ['id' => $id, 'email' => $email]);

            if ($stmt->rowCount() > 0)
                return $this->ret(true);
            return $this->ret(false, t('errors.bbdd.no_mail'));
        }
        catch (PDOException $e)
        {
            if ($e->errorInfo[0] == '23505')
                return $this->ret(false, t('errors.bbdd.email_exists'));
            return $this->ret(false, $e->getMessage());
        }
    }

    public function pass(int $id, string $pass): array
    {
        $hash = password_hash($pass, PASSWORD_DEFAULT);        
        try
        {
            $stmt = $this->execute("UPDATE users SET password_hash = :pass WHERE id = :id", ['id' => $id, 'pass' => $hash]);

            if ($stmt->rowCount() > 0)
                return $this->ret(true);
            return $this->ret(false, t('errors.bbdd.no_exist'));
        }
        catch (PDOException $e)
        {
            return $this->ret(false, $e->getMessage());
        }
    }
}