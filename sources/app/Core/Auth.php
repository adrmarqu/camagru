<?php

final class Auth
{
    /* Check if user is loggued */
    public static function check(): bool
    {
        return isset($_SESSION['user']);
    }

    /* Return user data */
    public static function user(): ?array
    {
        return $_SESSION['user'] ?? null;
    }

    /* Return user name */
    public static function username(): ?string
    {
        return $_SESSION['user']['name'] ?? null;
    }

    /* Return user id */
    public static function id(): ?int
    {
        return $_SESSION['user']['id'] ?? null;
    }

    /* Set session data */
    public static function login(int $id, string $user, string $email): void
    {
        session_regenerate_id(true);
        $_SESSION['user'] =
        [
            'id' => $id,
            'name' => $user,
            'email' => $email
        ];
    }

    /* Destroy session */
    public static function logout(): void
    {
        unset($_SESSION['user']);
        session_regenerate_id(true);
    }

    /* Log with the cookie */
    public static function loginWithCookie(): void
    {
        // Check if user already logged or if you dont have the cookie
        if (Auth::check() || !isset($_COOKIE['remember_me'])) return ;

        $model = new TokenModel();

        // Get user and token data
        $data = $model->findWithUser($_COOKIE['remember_me']);
        if ($data === false || empty($data))
        { self::cleanCookie(); return ; }

        // Check if token is expired
        if (time() > strtotime($data['expires_at']))
        {
            $model->deleteById($data['token_id']);
            self::cleanCookie(); 
            return ;
        }

        // Renovate token
        $token = TokenHelper::generateToken();
        if ($model->create($data['user_id'], $token, 'remember') === false)
        { self::cleanCookie(); return ; }

        // Save data
        self::setCookie($token);
        Auth::login($data['user_id'], $data['username'], $data['email']);
    }

    /* New cookie */
    public static function setCookie(string $token): void
    {
        setcookie('remember_me', $token, time() + (86400 * 30), '/', '', true, true);
    }

    /* Delete cookie */
    private static function cleanCookie(): void
    {
        setcookie('remember_me', '', time() - 3600, '/', '', true, true);
    }
}