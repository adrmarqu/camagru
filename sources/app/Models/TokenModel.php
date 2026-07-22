<?php

class TokenModel extends BaseModel
{
    /* Returns if a token has expired or not */
    public function isExpired(string $expire): bool
    {
        if (empty($expire)) throw new AppException(500);

        $expiredDate = new DateTime($expire);
        $now = new DateTime();

        return $now > $expiredDate;
    }

    /* Get token by userid and token type */
    private function getToken(int $userid, string $type): array|false
    {
        $sql = "SELECT id, token, expires_at FROM tokens WHERE type = :type AND user_id = :id";
        $params = ['id' => $userid, 'type' => $type];
        return $this->select($sql, $params);
    }

    /* Get token by userid and token type */
    public function getTokenByName(string $token): array|false
    {
        $sql = "SELECT * FROM tokens WHERE token = :token";
        $params = ['token' => hash('sha256', $token)];
        return $this->select($sql, $params);
    }

    /* Delete token by token id */
    public function deleteTokenByID(int $id): void
    {
        $sql = "DELETE FROM tokens WHERE id = :id";
        $params = ['id' => $id];
        if ($this->query($sql, $params) === 0)
            throw new AppException(500);
    }

    /* Delete token by user id and type */
    public function deleteToken(int $userid, string $type): int
    {
        $sql = "DELETE FROM tokens WHERE user_id = :id AND type = :type";
        $params = ['id' => $userid, 'type' => $type];
        return $this->query($sql, $params);
    }

    /* Generate a token and insert it in db, return the token */
    public function generateToken(int $userid, string $type, int $seconds, bool $deleted = false): string
    {
        /* Only if you did not deleted the token */
        if ($deleted === false)
        {
            /* Get token */
            $data = $this->getToken($userid, $type);

            /* If you hava a valid token return it, else cou create a new token */
            if ($data && !$this->isExpired($data['expires_at']))
                return $data['token'];

            /* If you have a expired token, delete it */
            if ($data)
                $this->deleteTokenById($data['id']);
        }
        /* Generate token */
        $rawToken = bin2hex(random_bytes(32));

        /* Get time */
        $expiresAt = date('Y-m-d H:i:s', time() + $seconds);

        /* Insert token in db */
        $sql = "INSERT INTO tokens (token, expires_at, user_id, type) VALUES (:token, :expires, :id, :type)";
        $params =
        [
            'token' => hash('sha256', $rawToken),
            'expires' => $expiresAt,
            'id' => $userid,
            'type' => $type 
        ];
        if ($this->query($sql, $params) === 0)
            throw new AppException(500);

        return $rawToken;
    }
}