<?php

final class CookieController extends AuthController
{
    const TIME_REMEMBER = (30 * 24 * 60 * 60); // Day, Hour, Minute, Second

    /* Check if exist a token and log with him */
    public function loginWithCookie(string $token): void
    {
        $model = new UserModel();

        /* Get user and token data with the token */
        $data = $model->findTokenWithUser($token);
        /* Check if exists in the db */
        if ($data === false || empty($data))
        {
            $this->clearRememberCookie();
            return ;
        }
        /* Check if token is expired */
        if (time() > strtotime($data['expires_at']))
        {
            $model->deleteTokenById($data['token_id']);
            $this->clearRememberCookie();
            return ;
        }
        /* Update new token */
        $model->deleteTokenById($data['token_id']);
        $rawToken = $model->generateToken($data['user_id'], 'remember', self::TIME_REMEMBER, true);
        
        // Save data in session
        $this->setRememberCookie($rawToken);
        $this->setUserSession([
            'id' => $data['user_id'],
            'name' => $data['username'],
            'email' => $data['email']
        ]);
    }

    /* Delete the remember token and create a new one */
    public function remember(int $id): void
    {
        $model = new TokenModel();

        // Delete token
        $model->deleteToken($id, 'remember');

        // Create a new one
        $rawToken = $model->generateToken($id, 'remember', self::TIME_REMEMBER, true);

        // Save cookie
        $this->setRememberCookie($rawToken);
    }

    /* Logout - Delete Session user, Delete token, Delete cookie */
    public function logout(): void
    {
        $model = new TokenModel();
        $model->deleteToken($_SESSION['user']['id'], 'remember');

        unset($_SESSION['user']);
        $this->clearRememberCookie();
    }

    private function clearRememberCookie(): void
    {
        setcookie('remember_me', '', time() - 3600, '/', '', true, true);
    }

    public static function setRememberCookie(string $token): void
    {
        setcookie('remember_me', $token, time() + (86400 * 30), '/', '', true, true);
    }

    public function setUserSession(array $user): void
    {
        $_SESSION['user'] =
        [
            'id' => $user['id'],
            'name' => $user['username'],
            'email' => $user['email']
        ];
    }
}