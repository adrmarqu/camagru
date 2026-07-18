<?php

class AuthController extends BaseController
{
    public function login()
    {
        /* if ($_SERVER['REQUEST_METHOD'] === 'POST')
        {

        } */

        $this->render('/auth/login', AuthSources::login());
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

            $errors = AuthService::signin($user, $email, $password, $confirm, $terms);

            if (empty($errors))
            {
                $db = Database::getConn();
                try
                {
                    $db->beginTransaction();

                    /* Create user */
                    $model = new AuthModel();
                    $id = $model->signin($user, $email, $password);

                    /* Create token */
                    $model = new TokenModel();
                    $token = $model->generateTokenAccount($id);
                    
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
                    throw new DBException(['global' => Lang::t('error.send')]);
                } 
                catch (DBException $e)
                {
                    $db->rollBack();
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