<?php

/* Login, Signin, Forgot, Cookie(con logout) */
abstract class AuthController extends BaseController
{
    protected const LOGIN_HTML_URL = "/auth/login";
    protected const SIGNIN_HTML_URL = "/auth/signin";
    protected const FORGOT_HTML_URL = "/auth/forgot";

    /* Account: 10min, Password: 5min, Email: 15min */
    protected function sendEmail(int $id, string $email, string $type = 'account', int $tokenTime = (10 * 60)): void
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