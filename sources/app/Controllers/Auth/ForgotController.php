<?php

class ForgotController extends BaseController
{
    private string $email;

    public function init(array $data): void
    {
        $this->email = Utils::trim($data['email']);
    }

    public function validate(): void
    {
        $errors = [];
        $void = Lang::t('form.void');

        if (Validate::empty($this->email))
            $errors['email'] = $void;
        else if (!Validate::user($this->email))
            $errors['email'] = Lang::t('form.error.email');

        if (!empty($errors))
            throw new FormException(422, null, $errors);
    }

    public function execute(): void
    {
        // Generate token
        $token = TokenHelper::generateToken();

        // Get id, if email no exists id = 0
        $model = new UserModel();
        $id = $model->getUserId($this->email);
        if (empty($id)) $id = 0;

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