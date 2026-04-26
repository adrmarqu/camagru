<?php

require_once BACKEND . 'model/BaseModel.php';

class TokenModel extends BaseModel
{
    /* Account token */
    /* Generate account token */
    public function generateAccount(int $userid, string $email): array
    {
        $type = 'account';
        $code = $this->generateVerificationNumber();
        $hash = hash('sha256', $code);
        try 
        {
            $this->execute(
                "INSERT INTO tokens (user_id, token, type, expires_at, attempts) VALUES (:id, :token, :t, :expires_at, 0) ON CONFLICT (user_id, type) DO UPDATE SET token = EXCLUDED.token, expires_at = EXCLUDED.expires_at, attempts = 0", 

                ['id' => $userid, 'token' => $hash, 't' => $type, 'expires_at' => date('Y-m-d H:i:s', time() + $this->time)]
            );

            $mail = new MailService();
            $mail->sendVerificationEmail($email, $code);

            return $this->ret(true, t('form.code'));
        }
        catch (PDOException $e)
        {
            return $this->ret(false, $e->getMessage());
        }
    }

    /* Verificate account token */
    public function account(int $userid, string $code): array
    {
        $type = 'account';
        try
        {
            $data = $this->getFetch("SELECT token, expires_at, attempts FROM tokens WHERE user_id = :id AND type = :t", ['id' => $userid, 't' => $type]);

            if (empty($data))
                return $this->ret(false, t('errors.bbdd.new_code'));

            if (time() > strtotime($data['expires_at']))
            {
                $this->delete($userid, 'account');
                return $this->ret(false, t('errors.bbdd.expired'));
            }

            if ($data['attempts'] >= 3)
                return $this->ret(false, t('errors.bbdd.attempts'));

            if (!hash_equals($data['token'], hash('sha256', $code)))
            {
                $this->execute("UPDATE tokens SET attempts = attempts + 1 WHERE user_id = :id AND type = :t", ['id' => $userid, 't' => $type]);

                return $this->ret(false, t('errors.bbdd.pass'));
            }
            $this->delete($userid, $type);
            return $this->ret(true);
        }
        catch (PDOException $e)
        {
            return $this->ret(false, $e->getMessage());
        }
    }

    /* Email token */
    /* New token of email */
    public function generateEmail(int $userid, string $email): array
    {
        $type = 'email';
        try
        {
            $this->execute(
                "INSERT INTO tokens (user_id, token, type, expires_at, new_value) VALUES (:id, :token, :t, :expires_at, :email) ON CONFLICT (user_id, type) DO UPDATE SET token = EXCLUDED.token, expires_at = EXCLUDED.expires_at, new_value = EXCLUDED.new_value", 

                ['id' => $userid, 'token' => $hash, 't' => $type, 'expires_at' => date('Y-m-d H:i:s', time() + $this->time), 'new_value' => $email]
            );
            
            $mail = new MailService();
            $mail->sendVerificationEmail($email, $code);

            return $this->ret(true, t('form.code'));
        }
        catch (PDOException $e)
        {
            return $this->ret(false, $e->getMessage());
        }
    }

    /* Check email token */
    public function email(int $userid, string $token): array
    {
        $type = 'email';
        try
        {
            $data = $this->getFetch("SELECT token, new_value, expires_at FROM tokens WHERE user_id = :id AND type = :t", ['id' => $userid, 't' => $type]);

            if (empty($data))
                return $this->ret(false, t('errors.bbdd.email_no'));            

            if (time() > strtotime($data['expires_at']))
            {
                $this->delete($userid, 'email');
                return $this->ret(false, t('errors.bbdd.expired'));
            }

            if (!hash_equals($data['token'], hash('sha256', $token)))
                return $this->ret(false, t('errors.bbdd.token'));

            $email = $data['new_value'];
            $this->delete($userid, $type);
            return $this->ret(true, '', '', '', $email);            
        }
        catch (PDOException $e)
        {
            return $this->ret(false, $e->getMessage());
        }
    }

    /* Delete all token expired */
    public function deleteExpired(): array
    {
        try
        {
            $this->execute("DELETE FROM tokens WHERE expires_at < NOW()", []);
            return $this->ret(true);
        }
        catch (PDOException $e)
        {
            return $this->ret(false, $e->getMessage());
        }
    }

    /* Delete used token */
    private function delete(int $userid, string $type): void
    {
        $this->execute("DELETE FROM tokens WHERE user_id = :id AND type = :t", ['id' => $userid, 't' => $type]);
    }
}