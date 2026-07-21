<?php

/* This class checks the texts formats of the POST from the forms and the tokens */
final class AuthHelper
{
    private function __construct() {}

    public static function login(string $login, string $password): array
    {
        $errors = [];

        // usermail
        if (($error = Validator::usermail($login)) !== null)
            $errors['usermail'] = $error;
        // pass
        if (Validator::pass($password) !== null)
            $errors['password'] = Lang::t('error.form.log_pass');

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
            $errors['terms'] = Lang::t('error.form.terms');

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
        /* Get token */
        $model = new TokenModel();
        $data = $model->getToken($token);

        /* No token */
        if (!$data)
        {
            self::clearCookie();
            return ;
        }

        /* Check if token has expired */
        if (time() > strtotime($data['expires_at']))
        {
            $model->deleteTokenById($data['id']);
            self::clearCookie();
            return ;
        }

        /* New token */
        $newToken = bin2hex(random_bytes(32));
        $model->updateRememberToken($data['id'], $newToken);

        /* Set cookie */
        self::setCookie($newToken);
        /* Set session */
        self::setSession($data);
    }

    /* Clean remember cookie */
    private static function clearCookie(): void
    {
        setcookie('remember_me', '', time() - 3600, '/', '', true, true);
    }

    /* Create remember cookie */
    public static function setCookie(string $token): void
    {
        setcookie('remember_me', $token, time() + (86400 * 30), '/', '', true, true);
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