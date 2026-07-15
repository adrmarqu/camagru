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
            $errors = AuthService::signin(
                $_POST['user'] ?? '',
                $_POST['email'] ?? '',
                $_POST['password'] ?? '',
                $_POST['confirm'] ?? '',
                isset($_POST['terms'])
            );
            if (empty($errors))
            {
                /* $model = new AuthModel(); */
                /* Error */
                Navigator::redirect('login');
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