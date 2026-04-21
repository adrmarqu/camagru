<?php

require_once BACKEND . 'model/BaseModel.php';

class UpdateModel extends BaseModel
{
    public function user(int $id, string $newuser): array
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

    public function email(int $id, string $newemail): array
    {
        try
        {
            /* 
            
                Si no esta repetido en users y tokens
                    Subirlo a tokens y enviar correo
            */
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

    public function pass(int $id, string $checkpass, string $newpass): array
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

    public function token(string $token): array
    {
        try
        {
            // Check token
            // Get email_tmp
            // Update email
        }
        catch (PDOException $e)
        {
            return $this->makeReturn(false, $e->getMessage());
        }
    }
}