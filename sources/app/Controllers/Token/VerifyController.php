<?php

class VerifyController extends BaseController
{
    public function __invoke()
    {
        $tokenStr = $_GET['token'];

        $model = new TokenModel();

        // Get token
        $token = $model->getToken($tokenStr);
        if ($token === false || empty($token))
            throw new HttpException(404, Lang::t('404.no_token'));

        // Check if expired
        if (TokenHelper::isExpired($token['expires_at']))
        {
            $model->deleteById($token['id']);
            throw new HttpException(410);
        }

        $this->useToken($tokenStr, $token);
    }

    private function activateAccount(int $userid, int $tokenid): void
    {
        $pdo = Database::getConnection();
        
        try
        {
            $pdo->beginTransaction();
           
            // Activate account
            $model = new UserModel();
            if ($model->activate($userid) === false)
                throw new HttpException(500, Lang::t('500.activate'));
            
            // Delete token
            $model = new TokenModel();
            if ($model->deleteById($tokenid) === false)
                throw new HttpException(500, Lang::t('500.delete_token'));

            $pdo->commit();

            unset($_SESSION['send']);
        }
        catch (Throwable $e)
        {
            $pdo->rollBack();

            throw $e;
        }
    }

    private function changeEmail(int $userid, string $email, int $tokenid): void
    {
        $pdo = Database::getConnection();

        try
        {
            $pdo->beginTransaction();

            // Search dup email
            $model = new UserModel();
            if ($model->emailExists($email))
                throw new HttpException(409);

            // Update email
            if ($model->updateEmail($userid, $email) === false)
                throw new HttpException(500, Lang::t('500.change_email'));
            
            // Delete token
            $model = new TokenModel();
            if ($model->deleteById($tokenid) === false)
                throw new HttpException(500, Lang::t('500.delete_token'));

            $pdo->commit();

            unset($_SESSION['send']);
        }
        catch (Throwable $e)
        {
            $pdo->rollBack();

            throw $e;
        }
    }

    private function useToken(string $token, array $data): void
    {
        $type = $data['type'] ?? '';

        switch ($type)
        {
            case 'account':
                $this->activateAccount($data['user_id'] ?? 0, $data['id']);
                break;
            case 'email':
                $this->changeEmail($data['user_id'] ?? 0, $data['new_email'] ?? '', $data['id']);
                break;
            case 'password':
                $_SESSION['reset_user_id'] = $data['user_id'];
                Navigator::redirect("reset-password?token=$token");
                break;
            default:
                throw new HttpException(500, Lang::t('500.type'));
        }
    }
}