<?php

class TokenController extends BaseController
{
    public function verify(array $params = [])
    {
        $this->render('/token/verify', TokenSources::verify());
    }
     
    public function reset()
    {
        $this->render('/token/reset', TokenSources::reset());
    }

    public function send()
    {
        // No hay $_SESSION['send_email'] entrada por url o desactualizado
        // 


        if (!isset($_SESSION['send_email']['action']))
        {

        }
            throw new AppException();
        $action = $_SESSION['send_email']['action'];
        
    }

    public function sendAccount()
    {
        if (isset($_SESSION['user']))
        $s = $_SESSION['send_email'] ?? null;

        if (empty($s) || empty($s['action']) || empty($s['email']) || empty($s['token']))
        {

        }

        $this->render('/token/send', AuthSources::send());
    }

    public function sendAccount()
    {
        if (isset($_SESSION['user']))
        $s = $_SESSION['send_email'] ?? null;

        if (empty($s) || empty($s['action']) || empty($s['email']) || empty($s['token']))
        {

        }

        $this->render('/token/send', AuthSources::send());
    }
}