<?php

class AuthModel extends BaseModel
{
    public function login()
    {
        
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