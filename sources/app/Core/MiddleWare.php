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
                if (isset($_SESSION['user']))
                    Navigator::redirect('gallery', 302);
                break ;
            // Only for logged users
            case 'private':
                if (!isset($_SESSION['user']))
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
        // Check if you have the user id
        if (isset($_SESSION['reset_user_id']))
            return ;

        // If you do not have the session then error
        if (isset($_SESSION['user']))
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
        $sendData = $_SESSION['send_email'] ?? null;

        if (empty($sendData))
            throw new HttpException(403, Lang::t('403.no_token'));

        $action = $sendData['action'] ?? null;
        $email  = $sendData['email']  ?? null;
        $token  = $sendData['token']  ?? null;

        if (!$action || !$email || !$token)
            throw new HttpException(403, Lang::t('403.no_token'));

        if ($action === 'account' && isset($_SESSION['user']))
            throw new HttpException(403);

        if ($action === 'email' && !isset($_SESSION['user']))
            throw new HttpException(401, null, '/login');
    }

    private function result()
    {
        if (!isset($_SESSION['result']))
            Navigator::redirect('gallery', 302);
    }
}