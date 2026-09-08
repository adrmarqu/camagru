<?php

class ForgotController extends BaseController
{
    private string $email;

    public function init(array $data): void
    {
        $this->email = Utils::trim($data['email'] ?? '');
    }

    public function validate(): void
    {
        $errors = [];
        $void = Lang::t('form.void');

        if (Validate::empty($this->email))
            $errors['email'] = $void;
        else if (!Validate::email($this->email))
            $errors['email'] = Lang::t('form.error.email');

        if (!empty($errors))
            throw new FormException(422, null, $errors);
    }

    public function execute(): ?string
    {
        // Generate token
        $token = TokenHelper::generateToken();

        // Get id, if email no exists id = 0
        $model = new UserModel();
        $userData = $model->getUserId($this->email);
        $id = !empty($userData['id']) ? (int)$userData['id'] : 0;

        // Send email
        $ctrl = new SendController();
        $ctrl->send($id, $this->email, $token, 'password');

        // Save data
        $_SESSION['send'] =
        [
            'id' => $id,
            'email' => $this->email,
            'action' => 'password',
            'token' => $token
        ];

        return null;
    }

    public function __invoke()
    {
        $data =
        [
            'css' => [ '/form.css' ],
            'scripts' => [ '/form.js' ]
        ];

        $this->render('/auth/forgot', $data);
    }
}