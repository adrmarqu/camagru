<?php

/* This class checks the texts formats of the POST from the forms and the tokens */
final class AuthHelper
{
    private function __construct() {}

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
        self::setSession([
            'id' => $data['user_id'],
            'username' => $data['username'],
            'email' => $data['email']
        ]);
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

    public static function logout(): void
    {
        unset($_SESSION['user']);
        self::clearCookie();
    }
}