<?php

class AuthModel extends BaseModel
{
    public function login()
    {
        
    }
    
    public function signin(string $user, string $email, string $pass): array
    {
        // Check if user already exists 
        $sql = "SELECT 1 FROM users WHERE username = :username";
        $params = ['username' => $user];
        $userExists = $this->select($sql, $params) !== false;
        // Check if email already exists s
        $sql = "SELECT 1 FROM users WHERE email = :email";
        $params = ['email' => $email];
        $emailExists = $this->select($sql, $params) !== false;

        if ($userExists && $emailExists)
        {
            return
            [
                'success' => false,
                'user' => Lang::t('error.bbdd.exist.user'),
                'email' => Lang::t('error.bbdd.exist.email')
            ];
        }
        else if ($userExists)
        {
            return
            [
                'success' => false,
                'user' => Lang::t('error.bbdd.exist.user'),
            ];
        }
        else if ($userExists)
        {
            return
            [
                'success' => false,
                'email' => Lang::t('error.bbdd.exist.email')
            ];
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
        return
        [
            'success' => true,
            'id' => $this->lastId()
        ];
    }

    public function forgot()
    {

    }
}