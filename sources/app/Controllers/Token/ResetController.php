<?php

final class ResetController extends TokenController
{
    public function checkFormat(string $password, string $confirm): array
    {
        $errors = [];

        // pass
        if (($error = Validator::pass($password)) !== null)
            $errors['password'] = $error;
        // confirm
        if (($error = Validator::confirm($password, $confirm)) !== null)
            $errors['confirm'] = $error;

        return $errors;
    }

    public function run(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            $id = $_SESSION['reset_user_id'];
            $password = $_POST['password'] ?? '';
            $confirm = $_POST['confirm'] ?? '';

            $errors = $this->checkFormat($password, $confirm);
            if (!empty($errors)) throw new FormException($errors);

            $model = new UserModel();
            $model->changePassword($id, $password);

            unset($_SESSION['reset_user_id']);

            Navigator::redirect('login');
        }

        $this->render(self::RESET_HTML_URL, TokenSources::reset());
    }
}