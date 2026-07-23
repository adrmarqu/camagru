<?php

final class ForgotController extends AuthController
{
    public function checkFormat(string $usermail): array
    {
        $errors = [];

        // usermail
        if (Validator::usermail($usermail) !== null)
            $errors['usermail'] = Lang::t('error.form.log_user');

        return $errors;
    }

    public function run()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            $usermail = $_POST['usermail'] ?? '';

            $errors = $this->checkFormat($usermail);
            if (!empty($errors)) throw new FormException($errors);

            $model = new UserModel();
            $user = $model->getUser($usermail);
            // Check if user no exists
            if ($user === false || empty($user))
            {
                throw new FormException(['usermail' => Lang::t('error.form.log_user')]);
            }
            $db = Database::getConnection();
            try
            {
                $db->beginTransaction();
                
                $this->sendEmail($user['id'], $user['email'], 'password', (5 * 60));
                
                $db->commit();
            }
            catch (Throwable $e)
            {
                $db->rollBack();
                throw $e;
            }
        }
        $this->render(self::FORGOT_HTML_URL, AuthSources::forgot());
    }
}