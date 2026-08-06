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

    public function process(): void
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
            $this->sendEmail($user['id'], $user['email'], AuthController::TOKEN_PASSWORD, AuthController::TIME_PASSWORD);
            $db->commit();
        }
        catch (Throwable $e)
        {
            $db->rollBack();
            throw $e;
        }
        
        header('Content-Type: application/json');
        echo json_encode(['success' => true]);
        exit;
    }

    public function run()
    {
        $this->render(self::FORGOT_HTML_URL, AuthSources::forgot());
    }
}