<?php

class LoginController extends BaseController
{
    private string $user;
    private string $pass;
    private bool $remember;

    public function init(array $data): void
    {
        $this->user = Utils::trim($data['usermail'] ?? '');
        $this->pass = $data['password'] ?? '';
        $this->remember = isset($data['remember_me']);
    }

    public function validate(): void
    {
        $errors = [];
        $void = Lang::t('form.void');

        // Check empty
        if (Validate::empty($this->user))
            $errors['usermail'] = $void;
        if (Validate::empty($this->pass))
            $errors['password'] = $void;

        // Throw error empty
        if (!empty($errors))
            throw new FormException(422, null, $errors);

        // Check format
        if (!Validate::usermail($this->user) || !Validate::pass($this->pass))
            throw new FormException(401, Lang::t('401.login'));
    }

    public function execute(): void
    {
        $model = new UserModel();
        
        // Get user
        $user = $model->getUser($this->user);
        if ($user === false || empty($user))
            throw new FormException(401, Lang::t('401.login'));
        
        // Check password
        if (!password_verify($this->pass, $user['password_hash']))
            throw new FormException(401, Lang::t('401.login'));
        
        // Check account state
        if (!$user['is_active'])
        {
            $token = TokenHelper::generateToken();
            $_SESSION['send'] = 
            [
                'id' => $user['id'],
                'action' => 'account',
                'email' => $user['email'],
                'token' => $token
            ];

            $ctrl = new SendController();
            $ctrl->send($user['id'], $user['email'], $token);

            throw new FormException(403, null, [], null, "send-email");
        }

        // Save data
        Auth::login($user['id'], $user['username'], $user['email']);
        
        // Set token remember
        if ($this->remember === true)
        {
            $token = TokenHelper::generateToken();
            if ($model->create($user['id'], $token, 'remember') === false)
            {
                self::cleanCookie();
                return ;
            }
            Auth::setCookie($token);
        }
    }

    public function __invoke()
    {
        $data =
        [
            'css' => [ '/form.css' ],
            'scripts' => [ '/form.js' ]
        ];

        $this->render('/auth/login', $data);
    }
}