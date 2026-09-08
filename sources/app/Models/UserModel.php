<?php

class UserModel extends BaseModel
{
    /* Get id of a user */
    public function getUserId(string $id): array | false
    {
        $sql = "SELECT id FROM users WHERE username = :user OR email = :email LIMIT 1";
        $params = ['user' => $id, 'email' => $id];
        return $this->select($sql, $params);
    }

    /* Get the user data */
    public function getUser(string $id): array | false
    {
        $sql = "SELECT * FROM users WHERE username = :user OR email = :email LIMIT 1";
        $params = ['user' => $id, 'email' => $id];
        return $this->select($sql, $params);
    }

    /* Get password of a user */
    public function getPass(int $userid): array | false
    {
        $sql = "SELECT password_hash FROM users WHERE id = :id LIMIT 1";
        return $this->select($sql, ['id' => $userid]);
    } 

    /* Check if a email exists */
    public function userExists(string $user): bool
    {
        $sql = "SELECT 1 FROM users WHERE username = :user LIMIT 1";
        return $this->select($sql, ['user' => $user]) !== false;
    }

    /* Check if a email exists */
    public function emailExists(string $email): bool
    {
        $sql = "SELECT 1 FROM users WHERE email = :email LIMIT 1";
        return $this->select($sql, ['email' => $email]) !== false;
    }

    /* Insert user into db */
    public function insertUser(string $user, string $email, string $pass): int
    {
        $sql = "INSERT INTO users (username, email, password_hash) VALUES (:user, :email, :pass)";
        $params =
        [
            'user' => $user,
            'email' => $email,
            'pass' => Utils::hash($pass)
        ];
        if ($this->query($sql, $params) !== 1)
            throw new FormException(500, Lang::t('500.db'));

        return $this->lastId();
    }

    /* Activate account */
    public function activate(int $id): bool
    {
        // Folder name where user upload photos
        $folder = TokenHelper::generateToken(16);

        $sql = "UPDATE users SET is_active = TRUE, folder = :folder WHERE id = :id LIMIT 1";
        return $this->query($sql, ['id' => $id, 'folder' => $folder]) === 1;
    }

    /* Update password */
    public function newPass(int $id, string $pass): bool
    {
        $sql = "UPDATE users SET password_hash = :pass WHERE id = :id LIMIT 1";
        $params =
        [
            'pass' => Utils::hash($pass),
            'id' => $id
        ];
        return $this->query($sql, $params) === 1;
    }

    /* Get user stats (photos, likes, comments) */
    public function getUserStats(int $userid): array | false
    {
        $sql = "SELECT 
            -- Total photos
            (SELECT COUNT(*) FROM photos WHERE user_id = :id) 
            AS total_photos,
            -- Total likes
            (SELECT COUNT(*)
            FROM likes l
            JOIN photos p ON l.photo_id = p.id
            WHERE p.user_id = :id) 
            AS total_likes,
            -- Total comments
            (SELECT COUNT(*)
            FROM comments c
            JOIN photos p ON c.photo_id = p.id
            WHERE p.user_id = :id)
            AS total_comments";

        return $this->select($sql, ['id' => $userid]);
    }

    /* Notification active */
    public function isEmailNotiActive(int $id): bool
    {
        $sql = "SELECT notification_active FROM users WHERE id = :id";
        $res = $this->select($sql, ['id' => $id]);
        return (bool) ($res['notification_active'] ?? false);
    }

    public function deleteAccount(int $id): bool
    {
        $sql = "DELETE FROM users WHERE id = :id LIMIT 1";
        return $this->query($sql, ['id' => $id]) === 1;
    }

    public function updateName(int $id, string $username): bool
    {
        $sql = "UPDATE users SET username = :user WHERE id = :id LIMIT 1";
        $params =
        [
            'user' => $username,
            'id' => $id
        ];
        return $this->query($sql, $params) === 1;
    }

    public function updateEmail(int $id, string $email): bool
    {
        $sql = "UPDATE users SET email = :email WHERE id = :id LIMIT 1";
        $params =
        [
            'email' => $email,
            'id' => $id
        ];
        return $this->query($sql, $params) === 1;
    }

    public function updateNoti(int $id, bool $active): bool
    {
        $sql = "UPDATE users SET notification_active = :a WHERE id = :id LIMIT 1";
        $params =
        [
            'a' => $active,
            'id' => $id
        ];
        return $this->query($sql, $params) === 1;
    }
}