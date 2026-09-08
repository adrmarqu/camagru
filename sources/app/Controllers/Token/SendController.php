<?php

class SendController extends BaseController
{
    private int $userid;
    private string $email;
    private string $token;
    private string $type;

    public function send(int $userid, string $email, string $token, string $type = 'account'): bool
    {
        // If email no exists do nothing
        $model = new UserModel();
        if ($type !== 'email' && !$model->emailExists($email))
            return true;

        $pdo = Database::getConnection();
        try
        {
            $pdo->beginTransaction();

            // Save token in db
            $model = new TokenModel();
            if ($model->create($userid, $token, $type, $email) === false)
                throw new FormException(500, Lang::t('500.token'));

            // Send email
            $mail = new Mailer($email, $token, $type);
            if ($mail->sendEmail() === false)
            {
                $pdo->rollBack();
                return false;
            }
            $pdo->commit();
        }
        catch (Throwable $e)
        {
            $pdo->rollBack();
            throw $e;
        }
        // Update new token
        $_SESSION['send']['token'] = $token;
        return true;
    }

    /* FORM PART */
    public function init(array $data): void
    {
        $this->userid = $_SESSION['send']['id'];
        $this->email = $_SESSION['send']['email'];
        $this->token = TokenHelper::generateToken();
        $this->type = $_SESSION['send']['action'];
    }

    public function validate(): void { return ;}

    public function execute(): ?string
    {
        $this->send($this->userid, $this->email, $this->token, $this->type);
        return null;
    }

    public function __invoke()
    {
        $data =
        [
            'css' => [ '/form.css' ],
            'scripts' => [ '/form.js' ]
        ];

        $this->render('/auth/send', $data);
    }
}