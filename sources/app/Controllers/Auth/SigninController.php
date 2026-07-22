<?php

final class SigninController extends AuthController
{
    private UserModel $model;

    public function __construct()
    {
        $this->model = new UserModel();
    }

    public function checkFormat(string $user, string $email, string $password, string $confirm, bool $terms): array
    {
        $errors = [];

        // user
        if (($error = Validator::user($user)) !== null)
            $errors['user'] = $error;
        // email
        if (($error = Validator::email($email)) !== null)
            $errors['email'] = $error;
        // pass
        if (($error = Validator::pass($password)) !== null)
            $errors['password'] = $error;
        // confirm
        if (($error = Validator::confirm($password, $confirm)) !== null)
            $errors['confirm'] = $error;
        // terms
        if ($terms === false)
            $errors['terms'] = Lang::t('error.form.terms');

        return $errors;
    }

    private function checkDataExists(string $user, string $email): void
    {
        $errors = [];

        if ($this->model->userExists($user))
            $errors['user'] = Lang::t('error.bbdd.exist.user');
        if ($this->model->emailExists($email))
            $errors['email'] = Lang::t('error.bbdd.exist.email');

        if (!empty($errors)) throw new FormException($errors);
    }

    public function run(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            $user = $_POST['user'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $confirm = $_POST['confirm'] ?? '';
            $terms = isset($_POST['terms']);

            // Check format
            $errors = $this->checkFormat($user, $email, $password, $confirm, $terms);
            if (!empty($errors)) throw new FormException($errors);
            // Check if already exists
            $this->checkDataExists($user, $email);

            $db = Database::getConnection();
            /* If something fail, db does not change */
            try
            {
                $db->beginTransaction();
                
                // Insert data 
                $id = $this->model->insertUser($user, $email, $password);
                /* Send email */
                $this->sendAccountEmail($id, $email);

                $db->commit();                
            }
            catch (Throwable $e)
            {
                $db->rollBack();
                throw $e;
            }
            Navigator::redirect("send-email");
        }
        $this->render(self::SIGNIN_HTML_URL, AuthSources::signin());
    }
}