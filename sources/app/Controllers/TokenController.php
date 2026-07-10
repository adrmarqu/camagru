<?php

class TokenController extends BaseController
{
    public function verify(array $params = [])
    {
        $this->render('/token/verify', TokenSources::verify());
    }
     
    public function reset(array $params = [])
    {
        $this->render('/token/reset', TokenSources::reset());

    }
}