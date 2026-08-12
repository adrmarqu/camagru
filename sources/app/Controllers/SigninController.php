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
        $this->user = Utils::trim($data['user']);
        $this->email = Utils::trim($data['email']);
        $this->pass = $data['password'];
        $this->conf = $data['confirm'];
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
        else if (!Validate::user($this->email))
            $errors['email'] = Lang::t('form.error.email');

        // Password
        if (Validate::empty($this->pass))
            $errors['password'] = $void;
        else if (!Validate::user($this->pass))
            $errors['password'] = Lang::t('form.error.pass');

        // Confirm password
        if (Validate::empty($this->conf))
            $errors['confirm'] = $void;
        else if (!Validate::user($this->conf))
            $errors['confirm'] = Lang::t('form.error.conf');

        // Terms
        if ($this->terms === false)
            $errors['terms'] = Lang::t('signin.no_terms');

        if (!empty($errors))
            throw new FormException(422, null, $errors);
    }

    public function execute(): void
    {
        $model = new UserModel();
        $errors = [];

        // Get user
        $user = $model->getUser($this->user, $this->email);

        // Check if already exists
        if ($user['username'] === $this->user)
            $errors['user'] = Lang::t('db.exists.user');
        if ($user['email'] === $this->email)
            $errors['email'] = Lang::t('db.exists.email');

        if (!empty($errors))
            throw new FormException(500, Lang::t('500.signin'), $errors);

        // Insert user
        $model->insertUser($this->user, $this->email, $this->pass);

        // Send email
        $token = TokenHelper::generateToken();
        $send = new SendController();
        if ($send->account($token) === false)
            throw new FormException(500, Lang::t('500.email'));

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