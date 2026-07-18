<?php

class TokenModel extends BaseModel
{
    private function isExpired(string $expire): bool
    {
        if (empty($expire)) throw new AppException(500);

        $expiredDate = new DateTime($expire);
        $now = new DateTime();

        return $now > $expiredDate;
    }

    private function deleteTokenByID(int $id): void
    {
        $sql = "DELETE FROM tokens WHERE id = :id";
        $params = ['id' => $id];
        $this->query($sql, $params);
    }

    private function deleteToken(int $userid, string $type): void
    {
        $sql = "DELETE FROM tokens WHERE type = :type AND user_id = :id";
        $params = ['id' => $userid, 'type' => $type];
        $this->query($sql, $params);
    }

    public function generateTokenAccount(int $id): string
    {
        $tokenExpired = false;

        /* Get token */
        $sql = "SELECT id, token, expires_at FROM tokens WHERE user_id = :id AND type = :type";
        $params = ['id' => $id, 'type' => 'account'];
        $data = $this->query($sql, $params)->fetch();

        /* Check if its expired */
        if ($data && $this->isExpired($data['expires_at']))
            $tokenExpired = true;

        /* New token */
        if (!$data || $tokenExpired === true)
        {
            if ($tokenExpired === true) $this->deleteTokenByID($data['id']);

            $token = bin2hex(random_bytes(32));

            $sql = "INSERT INTO tokens (token, expires_at, user_id) VALUES (:token, NOW() + INTERVAL 5 MINUTE, :id)";
            $params = ['id' => $id, 'token' => $token];
            $this->query($sql, $params);

            return $token;
        }
        /* Use old token */
        else if ($data && $data['token'])
            return $data['token'];
        else
            throw new DBException(['global' => Lang::t('error.db.generic')]);
    }
}