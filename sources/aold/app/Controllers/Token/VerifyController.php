<?php

final class VerifyController extends TokenController
{
    public function send(): void
    {
        $this->render(self::SEND_HTML_URL, TokenSources::send());
    }

    public function result(array $params = [])
    {
        if ($params['action'] === 'account')
            $this->render(self::RESULT_HTML_URL, TokenSources::account());
        else if ($params['action'] === 'email')
            $this->render(self::RESULT_HTML_URL, TokenSources::email());
        else
            throw new AppException(400);
    }

    public function run(array $query = []): void
    {
        $tokenRaw = $query['token'] ?? null;

        /* Token no exists in get */
        if (empty($tokenRaw))
            throw new AppException(400);

        $model = new TokenModel();

        // Get token
        $data = $model->getTokenByName($tokenRaw);
        if ($data === false || empty($data))
            throw new AppException(404, Lang::t('404.no_token'));
        
        // Check expired token
        if ($model->isExpired($data['expires_at']))
            throw new AppException(410);

        $db = Database::getConnection();
        try
        {
            $db->beginTransaction();

            // Delete used token except reset password
            if ($data['type'] !== 'password')
                $model->deleteTokenByID($data['id']);
            
            switch($data['type'])
            {
                case 'account':
                    $user = new UserModel();
                    $user->activateAccount($data['user_id']);

                    $url = 'result?action=account';
                    break ;
                case 'email':
                    $user = new UserModel();
                    $user->confirmEmail($data['user_id'], $data['new_email']);
                    
                    $url = 'result?action=email';
                    break ;
                case 'password':
                    $_SESSION['reset_user_id'] = $data['user_id'];

                    $url = 'reset-password';
                    break ;
                default:
                    throw new AppException(500);
            }
            $db->commit();
        }
        catch (Throwable $e)
        {
            $db->rollBack();
            throw $e;
        }
        // Delete session to forbid users to enter
        unset($_SESSION['send_email']);
        Navigator::redirect($url);
    }
}