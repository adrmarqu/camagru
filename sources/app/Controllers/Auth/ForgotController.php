<?php

final class ForgotController extends AuthController
{
    public function run()
    {
        $this->render(self::FORGOT_HTML_URL, AuthSources::forgot());
    }
}