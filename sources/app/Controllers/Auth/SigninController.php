<?php

class SigninController extends BaseController
{
    private string $user;
    private string $email;
    private string $pass;
    private string $conf;
    private bool $terms;

    public function init(array $data): void
    {
        $this->user = Utils::trim($data['user'] ?? '');
        $this->email = Utils::trim($data['email'] ?? '');
        $this->pass = $data['password'] ?? '';
        $this->conf = $data['confirm'] ?? '';
        $this->terms = isset($data['terms']);
    }

    public function validate(): void
    {
        $errors = [];
        $void = Lang::t('form.void');

        // User
        if (Validate::empty($this->user))
            $errors['user'] = $void;
        else if (!Validate::user($this->user))
            $errors['user'] = Lang::t('form.error.user');

        // Email
        if (Validate::empty($this->email))
            $errors['email'] = $void;
        else if (!Validate::email($this->email))
            $errors['email'] = Lang::t('form.error.email');

        // Password
        if (Validate::empty($this->pass))
            $errors['password'] = $void;
        else if (!Validate::pass($this->pass))
            $errors['password'] = Lang::t('form.error.pass');

        // Confirm password
        if (Validate::empty($this->conf))
            $errors['confirm'] = $void;
        else if (!Validate::confirm($this->pass, $this->conf))
            $errors['confirm'] = Lang::t('form.error.conf');

        // Terms
        if ($this->terms === false)
            $errors['terms'] = Lang::t('signin.no_terms');
        
        if (!empty($errors))
            throw new FormException(422, null, $errors);
    }

    public function execute(): ?string
    {
        $model = new UserModel();
        $errors = [];

        // Check if user exists
        if ($model->userExists($this->user))
            $errors['user'] = Lang::t('db.exists.user');

        // Check if email exists
        if ($model->emailExists($this->email))
            $errors['email'] = Lang::t('db.exists.email');

        if (!empty($errors))
            throw new FormException(409, null, $errors);

        // Insert user
        $id = $model->insertUser($this->user, $this->email, $this->pass);

        $token = TokenHelper::generateToken();
        $_SESSION['send'] = 
        [
            'id' => $id,
            'action' => 'account',
            'email' => $this->email,
            'token' => $token
        ];

        // Send email, if fail go to login
        $ctrl = new SendController();
        $ctrl->send($id, $this->email, $token);

        return null;
    }

    public function __invoke()
    {
        $data =
        [
            'css' => [ '/form.css' ],
            'scripts' => [ '/form.js' ]
        ];

        $this->render('/auth/signin', $data);
    }
}