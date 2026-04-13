<?php

class FormValidation
{
    private string  $user;
    private string  $email;
    private string  $pass;
    private string  $passRep;
    private string  $newPass;
    private bool    $terms;

    private string  $error;

    public function __construct(array $post)
    {
        $this->user = $post['user'] ?? '';
        $this->email = $post['email'] ?? '';

        $this->pass = $post['pass'] ?? '';
        $this->passRep = $post['passRep'] ?? '';
        $this->newPass = $post['newPass'] ?? '';
        
        $this->terms = $post['terms'] ?? '';
    }

    public function checkForm(string $type): array
    {
        $formats =
        [
            'login' => 'checkLogin',
            'signin' => 'checkSignin',
            'update-user' => 'checkUpdateUser',
            'update-email' => 'checkUpdateEmail',
            'update-pass' => 'checkUpdatePass'
        ];

        if (!isset($formats[$type]))
        {
            return
            [
                'success' => false,
                'message' => t('errors.form.format') ?? 'Invalid form type'
            ];
        }

        $method = $formats[$type];
         
        return
        [
            'success' => $this->$method(),
            'message' => $this->error ?? ''
        ];
    }

    private function checkLogin(): bool
    {
        return true;
    }

    private function checkSignin(): bool
    {
        if (!$this->checkUser($this->user))
        {
            $this->error = t('errors.form.user') ?? 'Error';
            return false;
        }
        
        if (!$this->checkEmail($this->email))
        {
            $this->error = t('errors.form.email') ?? 'Error';
            return false;
        }

        if (!$this->checkPass($this->pass))
        {
            $this->error = t('errors.form.pass') ?? 'Error';
            return false;
        }

        if (!$this->checkPassRep($this->pass, $this->passRep))
        {
            $this->error = t('errors.form.pass_rep') ?? 'Error';
            return false;
        }
        
        if ($this->terms === false)
        {
            $this->error = t('errors.form.terms') ?? 'Error';
            return false;
        }
        return true;
    }

    private function checkUpdateUser(): bool
    {
        // Hacer check (nuevo user)

        if (!$this->checkUser($this->user))
        {
            $this->error = t('errors.form.user') ?? 'Error';
            return false;
        }
        return true;
    }

    private function checkUpdateEmail(): bool
    {
        // Hacer check (nuevo email)

        if (!$this->checkEmail($this->email))
        {
            $this->error = t('errors.form.email') ?? 'Error';
            return false;
        }
        return true;
    }

    private function checkUpdatePass(): bool
    {
        // Hacer check (nueva pass + rep)

        if (!$this->checkPass($this->pass))
        {
            $this->error = t('errors.form.pass') ?? 'Error';
            return false;
        }

        if (!$this->checkPassRep($this->pass, $this->passRep))
        {
            $this->error = t('errors.form.pass_rep') ?? 'Error';
            return false;
        }
        return true;
    }

    /* 
    -------------------------------------------------------------------
    |                             UTILS                               |
    -------------------------------------------------------------------
    */

    private function checkUser(string $user): bool
    {
        $user = trim($user);

        $userPattern = '/^[a-zA-Z][a-zA-Z0-9_]{3,20}$/';

        if (!preg_match($userPattern, $user))
            return false;
        return true;
    }

    private function checkEmail(string $email): bool
    {
        $emailPattern = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/';

        if (!preg_match($emailPattern, $email))
            return false;
        return true;
    }

    private function checkPass(string $pass): bool
    {
        $passPattern = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[A-Za-z\d]{8,}$/';

        if (!preg_match($passPattern, $pass))
            return false;
        return true;
    }

    private function checkPassRep(string $pass, string $rep): bool
    {
        if ($pass !== $rep)
            return false;
        return true;

    }
}