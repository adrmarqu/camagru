<?php

require_once BACKEND . 'model/BaseModel.php';
require_once BACKEND . 'services/MailService.php';

class CodeModel extends BaseModel
{
    private int $time = 300;

    private function generateVerificationNumber(): string
    {
        return str_pad((string) random_int(0, 999999), 6, "0", STR_PAD_LEFT);
    }

    /* Send an email with the code */
    public function sendEmail(string $code, string $email): array
    {
        $mail = new MailService();
        return $mail->sendVerificationEmail($email, $code);
        
    }

    /* Create or update a pass code for a user */
    public function setVerificationCode(int $userid, string $email): array
    {
        try
        {
            $pdo = Database::getConnection();

            $sql = "INSERT INTO tokens (user_id, token, type, expires_at, attempts)
                VALUES (:id, :code, :type, :expires_at, 0)
                ON CONFLICT (user_id)
                DO UPDATE SET
                    code = EXCLUDED.code,
                    expires_at = EXCLUDED.expires_at,
                    attempts = 0
            ";

            $code = $this->generateVerificationNumber();

            $stmt = $pdo->prepare($sql);
            $stmt->execute(
            [
                'id' => $userid,
                'token' => $code,
                'type' => 'pass',
                'expires_at' => date('Y-m-d H:i:s', time() + $this->time),
            ]);

            $result = $this->sendEmail($code, $email);

            if ($result['success'] === false)
                return $this->makeReturn(false, $result['msg']);
            return $this->makeReturn(true, t('form.code'));
        }
        catch (PDOException $e)
        {
            return $this->makeReturn(false, $e->getMessage());
        }
    }

    /* Verificate post of the pass code */
    public function verification(int $userid, string $code): array
    {
        try
        {
            $pdo = Database::getConnection();

            $stmt = $pdo->prepare("SELECT code, expires_at, attempts FROM codes WHERE user_id = :id");

            $stmt->execute(['id' => $userid]);

            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!$data) // Select = 0
                return $this->makeReturn(false, t('errors.bbdd.new_code'));

            if (time() > strtotime($data['expires_at']))
                return $this->makeReturn(false, t('errors.bbdd.expired'));

            if ($data['attempts'] >= 3)
                    return $this->makeReturn(false, t('errors.bbdd.attempts'));

            if ($code !== $data['code'])
            {
                $upd = $pdo->prepare("UPDATE codes SET attempts = attempts + 1 WHERE user_id = :id");

                $upd->execute(['id' => $userid]);

                return $this->makeReturn(false, t('errors.bbdd.pass'));
            }
            return $this->makeReturn(true);
        }
        catch (PDOException $e)
        {
            return $this->makeReturn(false, $e->getMessage());
        }
    }

    /* Activate or disactivate account */
    public function updateUserVerification(int $userid, bool $activate): array
    {
        try
        {
            $pdo = Database::getConnection();

            $stmt = $pdo->prepare("UPDATE users SET is_verified = :activate WHERE id = :id");

            $stmt->execute(['id' => $userid, 'activate' => $activate]);

            return $this->makeReturn(true);
        }
        catch (PDOException $e)
        {
            return $this->makeReturn(false, $e->getMessage());
        }
    }

    /* Delete code after verification and expired time */
    public function deleteCode(int $userid): array
    {
        try
        {
            $pdo = Database::getConnection();

            $stmt = $pdo->prepare("DELETE FROM codes WHERE user_id = :id OR expires_at < NOW() WHERE user_id = :id");

            $stmt->execute(['id' => $userid]);

            return $this->makeReturn(true);
        }
        catch (PDOException $e)
        {
            return $this->makeReturn(false, $e->getMessage());
        }
    }
}