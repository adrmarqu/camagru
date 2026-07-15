<?php

/* This class checks the texts formats of the POST from the forms and the tokens */
abstract class AuthService
{
    public static function login(string $login, string $password): array
    {
        $errors = [];

        // usermail
        if (($error = Validator::usermail($login)) !== null)
            $errors['usermail'] = $error;
        // pass
        if (($error = Validator::pass($password)) !== null)
            $errors['password'] = $error;

        return $errors;
    }

    public static function signin(string $user, string $email, string $password, string $confirm, bool $terms): array
    {
        $errors = [];

        // user
        if (($error = Validator::user($user)) !== null)
            $errors['user'] = $error;
        // email
        if (($error = Validator::email($email)) !== null)
            $errors['email'] = $error;
        // pass
        if (($error = Validator::pass($password)) !== null)
            $errors['password'] = $error;
        // confirm
        if (($error = Validator::confirm($password, $confirm)) !== null)
            $errors['confirm'] = $error;
        // terms
        if ($terms === false)
            $errors['terms'] = Lang::t('error.terms');

        return $errors;
    }

    public static function forgotPass(string $usermail): array
    {
        $error = Validator::usermail($usermail);
        return $error ? ['usermail' => $error] : [];
    }

    /* Update user */
    public static function user(string $newUser): array
    {
        $error = Validator::user($newUser);
        return $error ? ['user' => $error] : [];
    }

    /* Update email */
    public static function email(string $newEmail): array
    {
        $error = Validator::usermail($newEmail);
        return $error ? ['email' => $error] : [];
    }

    /* Update password */
    public static function password(string $current, string $password, string $confirm): array
    {
        $errors = [];

        // Current pass
        if (($error = Validator::pass($current)) !== null)
            $errors['current'] = $error;
        // New pass
        if (($error = Validator::pass($password)) !== null)
            $errors['password'] = $error;
        // Confirm new pass
        if (($error = Validator::confirm($password, $confirm)) !== null)
            $errors['confirm'] = $error;

        return $errors;
    }

    public static function resetPass(string $password, string $confirm): array
    {
        $errors = [];

        // pass
        if (($error = Validator::pass($password)) !== null)
            $errors['password'] = $error;
        // confirm
        if (($error = Validator::confirm($password, $confirm)) !== null)
            $errors['confirm'] = $error;

        return $errors;
    }

    /* Remember me */
    public static function loginWithCookie(string $token): void
    {
        // Get data of the user with the token
        $model = new TokenModel();
        $data = $model->remember($token);
        /* Check error */
        if (!$data)
        {
            self::clearCookie();
            return ;
        }
        // Check if token has expired
        if (time() > strtotime($data['expires_at']))
        {
            $model->deleteToken($token);
            self::clearCookie();
            return ;
        }

        /* Set session */
        self::setSession($data);
    }

    /* Clean rememeber cookie */
    private static function clearCookie(): void
    {
        setcookie('remember_me', '', time() - 3600, '/', '', true, true);
    }

    /* Set session user data (remember & login) */
    public static function setSession(array $user): void
    {
        $_SESSION['user'] =
        [
            'id' => $user['id'],
            'username' => $user['username'],
            'email' => $user['email']
        ];
    }
}