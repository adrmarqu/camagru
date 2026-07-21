<?php

class AuthController extends BaseController
{
    private function sendAccountEmail(int $id, string $email, PDO $db): void
    {
        /* Get token */
        $model = new TokenModel();
        $token = $model->generateTokenAccount($id);
        
        /* Send email */
        if (SendEmail::account($email, $token))
        {
            $db->commit();
            $_SESSION['send_email'] =
            [
                'action' => 'account',
                'user_id' => $id,
                'email' => $email,
                'token' => $token
            ];
            Navigator::redirect("send-email");
        }
        throw new AppException(500, null, null, ['global' => Lang::t('error.send')]);
    }

    public function login()
    {
        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            $usermail = $_POST['usermail'] ?? '';
            $password = $_POST['password'] ?? '';
            $remember = isset($_POST['remeber_me']);

            $errors = AuthHelper::login($usermail, $password);

            if (empty($errors))
            {
                $db = Database::getConn();
                try
                {
                    $db->beginTransaction();

                    $model = new AuthModel();
                    $user = $model->login($usermail, $password);

                    /* User is not active */
                    if ($user['is_active'] === false)
                        $this->sendAccountEmail($user['id'], $user['email'], $db);
                    
                    $db->commit();

                    /* Save user data */
                    AuthHelper::setSession($user);

                    /* Set remember cookie */
                    if ($remember)
                    {
                        try
                        {
                            $model = new TokenModel();
                            $token = $model->generateTokenCookie($user['id']);
                        }
                        catch (Throwable $e) {}
                    }
                    
                    Navigator::redirect('gallery');
                }
                catch (AppException $e)
                {
                    $db->rollBack();
                    $errors['global'] = $e->getMessage() ?? '';
                    $errors = $e->getErrors();
                }
            }
        }
        $this->render('/auth/login', AuthSources::login($errors));
    }

    public function signin()
    {
        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            $user = $_POST['user'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $confirm = $_POST['confirm'] ?? '';
            $terms = isset($_POST['terms']);

            $errors = AuthHelper::signin($user, $email, $password, $confirm, $terms);

            if (empty($errors))
            {
                $db = Database::getConn();
                try
                {
                    $db->beginTransaction();

                    /* Create user */
                    $model = new AuthModel();
                    $id = $model->signin($user, $email, $password);

                    /* Create token and send email */
                    $this->sendAccountEmail($id, $email, $db);
                } 
                catch (AppException $e)
                {
                    $db->rollBack();
                    $errors['global'] = $e->getMessage() ?? '';
                    $errors = $e->getErrors();
                }
            }
        }
        $this->render('/auth/signin', AuthSources::signin($errors));
    }

    public function forgot()
    {
        /* if ($_SERVER['REQUEST_METHOD'] === 'POST')
        {

        } */

        $this->render('/auth/forgot', AuthSources::forgot());
    }
}