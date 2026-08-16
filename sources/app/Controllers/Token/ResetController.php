<?php

class ResetController extends BaseController
{
    private string $pass;
    private string $conf;

    public function init(array $data): void
    {
        $this->pass = $data['password'] ?? '';
        $this->conf = $data['confirm'] ?? '';
    }

    public function validate(): void
    {
        $errors = [];
        $void = Lang::t('form.void');

        // New password
        if (Validate::empty($this->pass))
            $errors['password'] = $void;
        else if (!Validate::user($this->pass))
            $errors['password'] = Lang::t('form.error.pass');

        // Confirm password
        if (Validate::empty($this->conf))
            $errors['confirm'] = $void;
        else if (!Validate::user($this->conf))
            $errors['confirm'] = Lang::t('form.error.conf');

        if (!empty($errors))
            throw new FormException(422, null, $errors);
    }

    public function execute(): void
    {
        // Get data
        $token = $_SESSION['reset_token'];
        $userid = $_SESSION['reset_user_id'];

        // Check if token has expired
        $tokenModel = new TokenModel();
        $tokenData = $tokenModel->getToken($token);
        
        // Token no exists (expired and deleted by the db)
        if ($tokenData === false || empty($tokenData))
        {
            $this->unsetReset();
            throw new HttpException(403, Lang::t('403.no_token'));
        }

        // Token expired
        if (TokenHelper::isExpired($tokenData['expires_at']))
        {
            $tokenModel->deleteById($tokenData['id']);
            $this->unsetReset();
            throw new HttpException(410);
        }

        $pdo = Database::getConnection();
        try
        {
            $pdo->beginTransaction();

            // Get old pass
            $userModel = new UserModel();
            $oldPass = $userModel->getPass($userid);
            if ($oldPass === false || empty($oldPass))
                throw new HttpException(500);

            // Check if the password is the same
            if (password_verify($this->pass, $oldPass['password_hash']))
                throw new HttpException(409, Lang::t('409.pass'));

            // Update password
            if ($userModel->newPass($userid, $this->pass) === false)
                throw new HttpException(500, Lang::t('500.update_pass'));

            // Delete token
            if ($tokenModel->delete($userid, 'password') === false)
                throw new HttpException(500, Lang::t('500.delete_token'));

            $pdo->commit();
        }
        catch (Throwable $e)
        {
            if ($pdo->inTransaction()) $pdo->rollBack();

            throw $e;
        }
        // Unset sessions
        $this->unsetReset();
    }

    private function unsetReset(): void
    {
        unset($_SESSION['send']);
        unset($_SESSION['reset_token']);
        unset($_SESSION['reset_user_id']);
    }

    public function __invoke()
    {
        // Save the token
        $_SESSION['reset_token'] = $_GET['token'];

        $data =
        [
            'css' => [ '/form.css' ],
            'scripts' => [ '/form.js' ]
        ];

        $this->render('/auth/reset', $data);
    }
}