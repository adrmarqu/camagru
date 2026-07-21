<?php

class AuthModel extends BaseModel
{
    public function login(string $login, string $password): array
    {
        $sql = "SELECT id, username, email, password_hash, is_active FROM users WHERE username = :usermail OR email = :usermail";
        $params = ['usermail' => $login];
        $user = $this->select($sql, $params);

        /* User does not exists */
        if ($user === false || empty($user))
        {
            throw new AppException(404, null, null, 
            [
                'usermail' => Lang::t('error.bbdd.exist.usermail')
            ]);
        }

        /* User password is wrong */
        if (!password_verify($password, $user['password_hash']))
        {
            if ($user === false || empty($user))
            {
                throw new AppException(404, null, null, 
                [
                    'usermail' => Lang::t('error.bbdd.exist.usermail')
                ]);
            }
        }
        return $user;
    }
    
    public function signin(string $user, string $email, string $pass): int
    {
        /* Check if account data already exists */
        $userExists = $this->userExists($user);
        $emailExists = $this->emailExists($email);

        if ($userExists && $emailExists)
        {
            throw new AppException(409, null, null,
            [
                'user' => Lang::t('error.bbdd.exist.user'), 
                'email' => Lang::t('error.bbdd.exist.email')
            ]);
        }
        else if ($userExists)
        {
            throw new AppException(409, null, null,
            [
                'user' => Lang::t('error.bbdd.exist.user'), 
            ]);
        }
        else if ($userExists)
        {
            throw new AppException(409, null, null,
            [
                'email' => Lang::t('error.bbdd.exist.email')
            ]);
        }

        // Insert data
        $sql = "INSERT INTO users (username, email, password_hash) VALUES (:username, :email, :pass)";
        $params =
        [
            'username' => $user,
            'email' => $email,
            'pass' => password_hash($pass, PASSWORD_DEFAULT)
        ];
        $this->query($sql, $params);

        return $this->lastId();
    }

    public function forgot()
    {

    }
}