<?php

class TokenModel extends BaseModel
{
    /* Remember me */
    public function findWithUser(string $token): array | false
    {
        $hash = TokenHelper::hashToken($token);

        $sql = "SELECT 
                    t.id AS token_id,
                    t.user_id,
                    t.expires_at,
                    u.username,
                    u.email,
                    u.folder
                FROM tokens t
                INNER JOIN users u ON t.user_id = u.id
                WHERE t.token = :token 
                  AND t.type = 'remember'
                LIMIT 1";
        
        return $this->select($sql, ['token' => $hash]);
    }

    public function getToken(string $token): array | false
    {
        $sql = "SELECT id, type, new_email, expires_at, user_id FROM tokens WHERE token = :token LIMIT 1";
        return $this->select($sql, ['token' => TokenHelper::hashToken($token)]);
    }

    /* Get token by user id and type */
    public function getTokenByUser(int $userid, string $type): array | false
    {
        $sql = "SELECT 1 FROM tokens WHERE user_id = :id AND type = :type LIMIT 1";
        return $this->select($sql, ['id' => $userid, 'type' => $type]);
    }

    /* Delete by token id */
    public function deleteById(int $id): bool
    {
        $sql = "DELETE FROM tokens WHERE id = :id LIMIT 1";
        return $this->query($sql, ['id' => $id]) === 1;
    }

    /* Delete by user id and type */
    public function delete(int $userid, string $type): bool
    {
        $sql = "DELETE FROM tokens WHERE user_id = :id AND type = :type LIMIT 1";
        return $this->query($sql, ['id' => $userid, 'type' => $type]) === 1;
    }

    /* Delete old token and create a new one */
    public function create(int $userid, string $token, string $type, string $email = null): bool
    {
        // Check if token exists
        if ($this->getTokenByUser($userid, $type) !== false)
        {
            // Delete token, if fails return false
            if ($this->delete($userid, $type) === false)
                return false;
        }

        // Get token time
        $expiresAt = $this->getTime($type);
        if (empty($expiresAt)) return false;
        
        // Insert new token
        $sql = "INSERT INTO tokens (token, expires_at, user_id, type, new_email) VALUES (:token, :expires, :id, :type, :email)";
        $params =
        [
            'token' => TokenHelper::hashToken($token),
            'expires' => $expiresAt,
            'id' => $userid,
            'type' => $type,
            'email' => $email
        ];
        return $this->query($sql, $params) === 1;
    }

    /* Get token expired time */
    private function getTime(string $type): ?string
    {
        switch ($type)
        {
            case 'account':
                $time = 24 * 60 * 60; // 1 day
                break ;
            case 'email':
                $time = 15 * 60; // 15 minutes
                break ;
            case 'password':
                $time = 10 * 60; // 10 minutes
                break ;
            case 'remember':
                $time = 30 * 24 * 60 * 60; // 1 mounth
                break ;
            default: 
                return null;
        }
        return date('Y-m-d H:i:s', time() + $time);
    }    
}