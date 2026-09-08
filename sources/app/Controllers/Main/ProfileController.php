<?php

class ProfileController extends BaseController
{
    private string $user;
    private string $email;

    private string $pass;
    private string $new;
    private string $conf;

    private bool $noti;

    private string $action;

    public function init(array $data): void
    {
        $this->action = $data['action'] ?? '';

        // Info
        $this->user = $data['user'] ?? '';
        $this->email = $data['email'] ?? '';

        // Security
        $this->pass = $data['password'] ?? '';
        $this->new = $data['new'] ?? '';
        $this->conf = $data['confirm'] ?? '';

        // Preferences
        $this->noti = isset($data['notifications']);
    }

    private function validateInfo(): void
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

        if (!empty($errors))
            throw new FormException(422, null, $errors);
    }

    private function validateSecurity(): void
    {
        $errors = [];
        $void = Lang::t('form.void');

        // Password
        if (Validate::empty($this->new))
            $errors['password'] = $void;
        else if (!Validate::pass($this->new))
            $errors['password'] = Lang::t('form.error.pass');

        // Confirm password
        if (Validate::empty($this->conf))
            $errors['confirm'] = $void;
        else if (!Validate::confirm($this->new, $this->conf))
            $errors['confirm'] = Lang::t('form.error.conf');

        if (!empty($errors))
            throw new FormException(422, null, $errors);
    }

    // Change password check format
    public function validate(): void
    {
        if ($this->action === 'user') $this->validateInfo();
        else if ($this->action === 'password') $this->validateSecurity();
    }

    // Change password database
    public function execute(): ?string
    {
        $id = $_SESSION['user']['id'] ?? 0;
        if ($id === 0) throw new FormException(500);

        $u = $this->updateUser($id);
        $e = $this->updateEmail($id);
        $p = $this->updatePassword($id);
        $n = $this->updateNoti($id);

        if ($u && !$e) return Lang::t('200.user');
        else if (!$u && $e) return Lang::t('200.email');
        else if ($u && $e) return Lang::t('200.usermail');
        if ($p) return Lang::t('200.pass');
        if ($n) return Lang::t('200.noti');
        return null;
    }

    private function updateUser(int $userid): bool
    {
        if ($this->action !== 'user' || empty($this->user) || $_SESSION['user']['name'] === $this->user) return false;

        $model = new UserModel();
        if ($model->userExists($this->user))
            throw new FormException(409, Lang::t('db.exists.user'));
        if ($model->updateName($userid, $this->user) === false)
            throw new FormException(500, Lang::t('500.db'));

        $_SESSION['user']['name'] = $this->user;

        return true;
    }

    private function updateEmail(int $userid): bool
    {
        if ($this->action !== 'user' || empty($this->email) || $_SESSION['user']['email'] === $this->email) return false;

        $model = new UserModel();
        if ($model->emailExists($this->email))
        {
            throw new FormException(409, null, ['email' => Lang::t('db.exists.email')]);
        }

        // Send email
        $token = TokenHelper::generateToken();
        $ctrl = new SendController();
        if ($ctrl->send($userid, $this->email, $token, 'email') === false)
            throw new FormException(500, Lang::t('500.send'));
        return true;
    }

    private function updatePassword(int $userid): bool
    {
        if ($this->action !== 'password' || empty($this->pass) || empty($this->new) || empty($this->conf)) return false;

        $model = new UserModel();
        // Get pass
        $pass = $model->getPass($userid);
        if (empty($pass) || $pass === false)
            throw new Exception(500);
        // Check if password is correct
        if (!password_verify($this->pass, $pass['password_hash']))
        {
            throw new FormException(422, null, ['password' => Lang::t('422.pass')]);
        }
        // Check if password are equal
        if ($this->pass === $this->new)
            throw new FormException(409, null, ['new' => Lang::t('409.pass')]);
        // Update pass
        if ($model->newPass($userid, $this->new) === false)
            throw new FormException(500, Lang::t('500.db'));
        return true;
    }

    private function updateNoti(int $userid): bool
    {
        if ($this->action !== 'preferences') return false;

        $model = new UserModel();
        if ($model->updateNoti($userid, $this->noti) === false)
            throw new FormException(500, Lang::t('500.db'));
        
        return true;
    }

    public function __invoke()
    {
        $model = new UserModel();

        $stats = $model->getUserStats($_SESSION['user']['id']);
        if (empty($stats) || $stats === false)
            throw new HttpException(500, Lang::t('500.db'));

        $noti = $model->isEmailNotiActive($_SESSION['user']['id']);

        $data =
        [
            'css' => [ '/form.css', '/profile.css' ],
            'scripts' => [ '/form.js', '/profile.js' ],
            'nPhotos' => $stats['total_photos'] ?? 0,
            'nLikes' => $stats['total_likes'] ?? 0,
            'nComments' => $stats['total_comments'] ?? 0,
            'notiChecked' => $noti
        ];

        $this->render('/user/profile', $data);
    }
}