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
                $model = new AuthModel();
                $result = $model->signin($user, $email, $password);
                if ($result['success'])
                {
                    $t = new TokenModel();
                    $res = $t->generateTokenAccount($result['id'] ?? 0);
                    if ($res['success'])
                    {
                        $_SESSION['send_email'] =
                        [
                            'action' => 'account',
                            'email' => $email,
                            'token' => $res['token'] ?? null;
                        ];
                        Navigator::redirect("send-email");
                    }
                    else $errors = $res;
                }
                else $errors = $result;
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