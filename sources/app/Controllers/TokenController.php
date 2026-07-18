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

    public function send(): void
    {
        $this->render('/token/send', TokenSources::send());
    }
}