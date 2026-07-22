<?php

class UserModel extends BaseModel
{
    /* Check if a user already exists in the db */
    public function userExists($username): bool
    {
        $sql = "SELECT 1 FROM users WHERE username = :username";
        $params = ['username' => $username];
        return $this->select($sql, $params) !== false;
    }

    /* Check if a email already exists in the db */
    public function emailExists($email): bool
    {
        $sql = "SELECT 1 FROM users WHERE email = :email";
        $params = ['email' => $email];
        return $this->select($sql, $params) !== false;
    }

    /* Insert a new user in the db */
    public function insertUser(string $user, string $email, string $pass): int
    {
        $sql = "INSERT INTO users (username, email, password_hash) VALUES (:username, :email, :pass)";
        $params =
        [
            'username' => $user,
            'email' => $email,
            'pass' => password_hash($pass, PASSWORD_DEFAULT)
        ];
        if ($this->query($sql, $params) === 0)
            throw new FormException(null, Lang::t('500.signin'));

        return $this->lastId();
    }

    /* Get user by username or email */
    public function getUser(string $usermail): array|false
    {
        $sql = "SELECT * FROM users WHERE username = :usermail OR email = :usermail";
        $params = ['usermail' => $usermail];
        return $this->select($sql, $params);
    }

    /* Get token and user data */
    public function findTokenWithUser(string $rawToken): array|false
    {
        $hashedToken = hash('sha256', $rawToken);

        $sql = "SELECT 
                    t.id AS token_id,
                    t.user_id,
                    t.expires_at,
                    u.username,
                    u.email
                FROM tokens t
                INNER JOIN users u ON t.user_id = u.id
                WHERE t.token = :token 
                  AND t.type = 'remember'
                LIMIT 1";

        return $this->select($sql, ['token' => $hashedToken]);
    }

    public function activateAccount(int $userId): void
    {
        $sql = "UPDATE users SET is_active = :active WHERE id = :id";
        $params = ['id' => $userId, 'active' => TRUE];
        if ($this->query($sql, $params) === 0)
            throw new AppException(404, Lang::t('404.user'));
    }

    public function changeNewEmail(int $userId, string $newEmail): void
    {
        if ($this->emailExists($newEmail))
            throw new AppException(409, Lang::t('409.email'));

        $sql = "UPDATE users SET email = :email WHERE id = :id";
        $params = ['id' => $userId, 'email' => $newEmail];
        if ($this->query($sql, $params) === 0)
            throw new AppException(404, Lang::t('404.user'));
    }

    /* reset-password: password */
    /* forgot-password: current_password + new_password */
    public function changePassword(int $userId, string $newPass, ?string $currentPass = null): void
    {
        /* Only from profile */
        if (!empty($currentPass))
        {
            $sql = "SELECT password_hash FROM users WHERE id = :id";
            $user = $this->select($sql, ['id' => $userId]);

            if ($user === false || empty($user))
                throw new AppException(404, Lang::t('404.user'));

            if (!password_verify($currentPass, $user['password_hash']))
                throw new AppException(401, Lang::t('401.pass'));
        }

        $sql = "UPDATE users SET password_hash = :hash WHERE id = :id";
        $params =
        [
            'id' => $userId,
            'hash' => password_hash($newPass, PASSWORD_DEFAULT)
        ];
        if ($this->query($sql, $params) === 0)
            throw new AppException(404, Lang::t('404.new_pass'));
    }
}