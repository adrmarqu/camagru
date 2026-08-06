<?php

final class LoginController extends AuthController
{
    public function checkFormat(string $usermail, string $password): array
    {
        $errors = [];

        // usermail
        if (Validator::usermail($usermail) !== null)
            $errors['usermail'] = Lang::t('error.form.log_user');
        // pass
        if (Validator::pass($password) !== null)
            $errors['password'] = Lang::t('error.form.log_pass');

        return $errors;
    }

    public function process(): void
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
        {
            throw new FormException(['usermail' => Lang::t('error.form.log_user')]);
        }
        // Check password
        if (!password_verify($password, $user['password_hash']))
        {
            throw new FormException([
                'password' => Lang::t('error.form.log_pass')
            ]);
        }
        // Check active account
        if ($user['is_active'] === false)
        {
            try
            {
                $db->beginTransaction();
                $this->sendEmail($user['id'], $user['email'], AuthController::TOKEN_ACCOUNT, AuthController::TIME_ACCOUNT);
                $db->commit();
            }
            catch (Throwable $e)
            {
                $db->rollBack();
                throw $e;
            }
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
        Navigator::redirect('gallery');
    }

    public function run(): void
    {
        $this->render(self::LOGIN_HTML_URL, AuthSources::login());
    }
}