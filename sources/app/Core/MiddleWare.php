<?php

class MiddleWare
{
    public function __invoke(?string $access, ?string $token): void
    {
        // Check if exists
        if (empty($access))
            throw new HttpException(404);

        if ($access === 'public') return ;

        switch ($access)
        {
            // Only for no logged users
            case 'guest':
                if (Auth::check())
                    Navigator::redirect('gallery', 302);
                break ;
            // Only for logged users
            case 'private':
                if (!Auth::check())
                    throw new HttpException(401, null, '/login');
                break ;
            // Only with token
            case 'token':
                $this->handleToken($token);
                break ;
            default:
                throw new HttpException(500);
        }
    }

    private function handleToken(?string $token): void
    {
        if (empty($token))
            throw new HttpException(404);

        switch ($token)
        {
            case 'verify':
                $this->verify();
                break ;
            case 'send':
                $this->sendEmail();
                break ;
            case 'reset':
                $this->resetPassword();
                break ;
            case 'result':
                $this->result();
                break ;
            default:
                throw new HttpException(500);
        }
    }

    private function resetPassword(): void
    {
        // Check token
        if (!isset($_GET['token']) || empty($_GET['token']))
            throw new HttpException(400);

        // Check if you have the user id
        if (isset($_SESSION['reset_user_id']))
            return ;

        // If you do not have the session then error
        if (Auth::check())
            throw new HttpException(403, Lang::t('403.no_token'));
        else
            throw new HttpException(401, Lang::t('403.no_token'), '/login');
    }

    private function verify(): void
    {
        // Check that token exists
        if (!isset($_GET['token']) || empty($_GET['token']))
            throw new HttpException(400);
    }

    private function sendEmail(): void
    {
        $sendData = $_SESSION['send'] ?? null;

        if (empty($sendData))
            throw new HttpException(403, Lang::t('403.no_token'));

        $userid = $sendData['id'] ?? null;
        $action = $sendData['action'] ?? null;
        $email  = $sendData['email']  ?? null;
        $token  = $sendData['token']  ?? null;

        if (!$userid || !$action || !$email || !$token)
            throw new HttpException(403, Lang::t('403.no_token'));

        if (($action === 'account' || $action === 'password') && Auth::check())
            throw new HttpException(403);

        if ($action === 'email' && !Auth::check())
            throw new HttpException(401, null, '/login');
    }

    private function result()
    {
        // If no exists get type
        if (!isset($_GET['type']))
        {
            if (Auth::check()) throw new HttpException(403);
            throw new HttpException(401);
        }

        // If exists but is wrong
        $type = $_GET['type'];
        if ($type !== 'account' && $type !== 'email' && $type !== 'reset')
            throw new HttpException(404, Lang::t('404.get'));
    }
}