<?php

require_once BACKEND . 'model/BaseModel.php';

class CodeModel extends BaseModel
{
    private int $time = 300;

    private function generateVerificationNumber(): int
    {
        return str_pad(random_int(0, 999999), 6, "0", STR_PAD_LEFT);
    }

    public function setVerificationCode(int $userid): array
    {
        try
        {
            $pdo = Database::getConnection();

            $sql = "INSERT INTO codes (user_id, code, expires_at, attempts)
                VALUES (:id, :code, :expires_at, 0)
                ON CONFLICT (user_id)
                DO UPDATE SET
                    code = EXCLUDED.code,
                    expires_at = EXCLUDED.expires_at,
                    attempts = 0
            ";

            $stmt = $pdo->prepare($sql);

            $stmt->execute(
            [
                'id' => $userid,
                'code' => $this->generateVerificationNumber(),
                'expires_at' => date('Y-m-d H:i:s', time() + $this->time),
            ]);

            return $this->makeReturn(true, t('form.code'));

        }
        catch (PDOException $e)
        {
            return $this->makeReturn(false, $e->getMessage());
        }
    }

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

    public function updateUserVerification(int $userid): array
    {
        try
        {
            $pdo = Database::getConnection();

            $stmt = $pdo->prepare("UPDATE users SET is_verified = true WHERE id = :id");

            $stmt->execute(['id' => $userid]);

            return $this->makeReturn(true);
        }
        catch (PDOException $e)
        {
            return $this->makeReturn(false, $e->getMessage());
        }
    }

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