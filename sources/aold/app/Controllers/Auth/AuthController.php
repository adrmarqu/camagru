<?php

/* Login, Signin, Forgot, Cookie(with logout) */
abstract class AuthController extends BaseController
{
    protected const LOGIN_HTML_URL = "/auth/login";
    protected const SIGNIN_HTML_URL = "/auth/signin";
    protected const FORGOT_HTML_URL = "/auth/forgot";

    // Token types
    public const TOKEN_ACCOUNT  = 'account';
    public const TOKEN_PASSWORD = 'password';
    public const TOKEN_EMAIL    = 'email';

    // Token lifespans (in seconds)
    public const TIME_ACCOUNT   = 24 * 60 * 60; // 24 hours
    public const TIME_PASSWORD  = 15 * 60;      // 15 minutes
    public const TIME_EMAIL     = 24 * 60 * 60; // 24 hours

    protected function sendEmail(int $id, string $email, string $type = self::TOKEN_ACCOUNT, int $tokenTime = self::TIME_ACCOUNT): void
    {
        // Create token
        $model = new TokenModel();
        $token = $model->generateToken($id, $type, $tokenTime);
        
        // Send email
        $send = new SendEmail($email, $token, $type);
        if ($send->sendEmail() === false)
            throw new FormException(null, Lang::t('error.send'));

        // Save session for send-email page
        $_SESSION['send_email'] =
        [
            'action' => $type,
            'user_id' => $id,
            'email' => $email,
            'token' => $token
        ];
    }
}