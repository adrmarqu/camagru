<?php

final class LoginController extends AuthController
{
    public function checkFormat(string $usermail, string $password): array
    {
        $errors = [];

        // usermail
        if (($error = Validator::usermail($usermail)) !== null)
            $errors['user'] = Lang::t('error.form.log_user');
        // pass
        if (($error = Validator::pass($password)) !== null)
            $errors['password'] = Lang::t('error.form.log_pass');

        return $errors;
    }

    public function run(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            $usermail = $_POST['usermail'] ?? '';
            $password = $_POST['password'] ?? '';
            $remember = isset($_POST['remember_me']);

            $errors = $this->checkFormat($usermail, $password);
            if (!empty($errors)) throw new FormException($errors);
            // Get user
            $model = new UserModel();
            $user = $model->getUser($usermail);
            // Check if user no exists
            if ($user === false || empty($user))
                throw new FormException(null, Lang::t('error.form.log_user'));
            // Check password
            if (!password_verify($password, $user['password_hash']))
                throw new FormException(null, Lang::t('error.form.log_pass'));
            // Check active account
            if ($user['is_active'] === false)
            {
                $this->sendAccountEmail($user['id'], $user['email']);
                Navigator::redirect("send-email");
            }
            $cookie = new CookieController();
            // Remember
            if ($remember)
            {
                try { $cookie->remember($user['id']); }
                catch (Throwable $e) { error_log(Lang::t('error.remember')); }
            }
            $cookie->setUserSession($user);
        }
        $this->render(self::LOGIN_HTML_URL, AuthSources::login());
    }
}