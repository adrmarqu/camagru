<?php

class TokenController extends BaseController
{
    public function verify(array $query = []): void
    {
        $tokenGet = $query['token'] ?? null;

        /* Token no exists in query */
        if (empty($tokenGet))
            throw new AppException(400);

        $db = Database::getConnection();
        try
        { 
            $db->beginTransaction();

            /* Manage token */
            $model = new TokenModel();
            $token = $model->verify($tokenGet);

            switch ($token['type'])
            {
                case 'account':
                    $user = new UserModel();
                    $user->activateAccount($token['user_id']);

                    $db->commit();

                    $nav = 'result?action=account';
                    break ;
                case 'email':

                    $user = new UserModel();
                    $user->changeNewEmail($token['user_id'], $token['new_email']);

                    $db->commit();

                    $nav = 'result?action=email';
                    break ;
                case 'password':

                    $db->commit();

                    $_SESSION['reset_user_id'] = $token['user_id'];
                    
                    Navigator::redirect("reset-password");
                    break;
                default:
                    throw new AppException(500);
            }
        }
        catch (AppException $e)
        {
            $db->rollBack();
            $error = new ErrorController();
            $error->display($e);
            return ;
        }
        unset($_SESSION['send_email']);
        Navigator::redirect($nav);
    }
     
    public function reset(): void
    {
        if (!isset($_SESSION['reset_user_id']))
        {
            if ($_SESSION['user'])
                throw new AppException(403);
            throw new AppException(401);
        }

        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            $password = $_POST['password'] ?? '';
            $confirm = $_POST['confirm'] ?? '';

            $errors = AuthHelper::resetPass($password, $confirm);

            if (empty($errors))
            {
                try
                {
                    $user = new UserModel();
                    $user->changePassword($_SESSION['reset_user_id'], $password);

                    unset($_SESSION['reset_user_id']);

                    Navigator::redirect('login');
                }
                catch (AppException $e)
                {
                    $errors = $e->getErrors();
                    if (empty($errors['global']))
                        $errors['global'] = $e->getMessage() ?? '';
                }
            }
        }
        $this->render('/token/reset', TokenSources::reset($errors));
    }

    public function send(): void
    {
        $this->render('/token/send', TokenSources::send());
    }

    public function result(array $params = [])
    {
        if ($params['action'] === 'account')
            $this->render('/token/result', TokenSources::account());
        else if ($params['action'] === 'email')
            $this->render('/token/result', TokenSources::email());
        else
            throw new AppException(400);
    }
}