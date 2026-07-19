<?php

class UserModel extends BaseModel
{
    public function activateAccount(int $userId): void
    {
        $sql = "UPDATE users SET is_active = :active WHERE id = :id";
        $params = ['id' => $userId, 'active' => TRUE];
        $stmt = $this->query($sql, $params);

        if ($stmt->rowCount() === 0)
            throw new AppException(404, Lang::t('404.user'));
    }

    public function changeNewEmail(int $userId, string $newEmail): void
    {
        if ($this->emailExists($newEmail))
            throw new AppException(409, Lang::t('409.email'));

        $sql = "UPDATE users SET email = :email WHERE id = :id";
        $params = ['id' => $userId, 'email' => $newEmail];
        $stmt = $this->query($sql, $params);

        if ($stmt->rowCount() === 0)
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
        $stmt = $this->query($sql, $params);

        if ($stmt->rowCount() === 0)
            throw new AppException(404, Lang::t('404.new_pass'));
    }
}