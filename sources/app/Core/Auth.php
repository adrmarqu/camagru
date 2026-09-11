<?php

final class Auth
{
    /* Check if user is logged */
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
    public static function username(): string
    {
        return $_SESSION['user']['name'] ?? Lang::t('header.guest') ?? 'Guest';
    }

    /* Return user id */
    public static function id(): ?int
    {
        return $_SESSION['user']['id'] ?? null;
    }

    /* Return user avatar url */
    public static function avatar(): string
    {
        $folder = $_SESSION['user']['folder'] ?? null;
        $default = '/assets/default.webp';
        if (empty($folder)) return $default;

        $avatarFile = PUBLIC_PATH . "/uploads/$folder/avatar/avatar.webp";
        if (file_exists($avatarFile))
        {
            return "/uploads/$folder/avatar/avatar.webp?v=" . filemtime($avatarFile);
        }
        return $default;
    }

    /* Set session data */
    public static function login(int $id, string $user, string $email, string $folder): void
    {
        session_regenerate_id(true);
        $_SESSION['user'] =
        [
            'id' => $id,
            'name' => $user,
            'email' => $email,
            'folder' => $folder
        ];
    }

    /* Destroy session */
    public static function logout(): void
    {
        if (isset($_SESSION['user']['id']))
        {
            try
            {
                $model = new TokenModel();
                $model->delete($_SESSION['user']['id'], 'remember');
            }
            catch (Throwable $e) {}
        }
        self::cleanCookie();
        unset($_SESSION['user']);
        session_regenerate_id(true);
    }

    /* Log with the cookie */
    public static function loginWithCookie(): void
    {
        // Check if user already logged or if you dont have the cookie
        if (Auth::check() || !isset($_COOKIE['remember_me'])) return ;

        try
        {
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
            Auth::login($data['user_id'], $data['username'], $data['email'], $data['folder'] ?? '');
        }
        catch (Throwable $e) {}
    }

    /* New cookie */
    public static function setCookie(string $token): void
    {
        setcookie('remember_me', $token, time() + (86400 * 30), '/', '', true, true);
    }

    /* Delete cookie */
    public static function cleanCookie(): void
    {
        setcookie('remember_me', '', time() - 3600, '/', '', true, true);
    }
}