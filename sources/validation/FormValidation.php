<?php

class FormValidation
{
    private string  $user;
    private string  $email;
    private string  $pass;
    private string  $passRep;
    private string  $newPass;
    private bool    $terms;

    public function __construct(array $post)
    {
        $this->user = $post['user'] ?? '';
        $this->email = $post['email'] ?? '';

        $this->pass = $post['pass'] ?? '';
        $this->passRep = $post['passRep'] ?? '';
        $this->newPass = $post['newPass'] ?? '';
        
        $this->terms = $post['terms'] ?? '';
    }

    public function checkForm(string $type, array $lang): bool
    {
        $functionName = 'check' . $type;
        if (!method_exists($this, $functionName))
        {
            $_SESSION['error'] = $lang['error_generic'] ?? 'Invalid form type';
            return false;
        }
        return $this->$functionName($lang);
    }

    private function checkSignin(array $lang): bool
    {
        if (!$this->checkUser($this->user))
        {
            $_SESSION['error'] = $lang['error_user'] ?? 'Error';
            return false;
        }
        
        if (!$this->checkEmail($this->email))
        {
            $_SESSION['error'] = $lang['error_email'] ?? 'Error';
            return false;
        }

        if (!$this->checkPass($this->pass))
        {
            $_SESSION['error'] = $lang['error_pass'] ?? 'Error';
            return false;
        }

        if (!$this->checkPassRep($this->pass, $this->passRep))
        {
            $_SESSION['error'] = $lang['error_pass_rep'] ?? 'Error';
            return false;
        }
        
        if ($this->terms === false)
        {
            $_SESSION['error'] = $lang['error_terms'] ?? 'Error';
            return false;
        }
        return true;
    }

    private function checkUpdateUser(array $lang): bool
    {
        // Hacer check (nuevo user)

        if (!$this->checkUser($this->user))
        {
            $_SESSION['error'] = $lang['error_user'] ?? 'Error';
            return false;
        }
        return true;
    }

    private function checkUpdateEmail(array $lang): bool
    {
        // Hacer check (nuevo email)

        if (!$this->checkEmail($this->email))
        {
            $_SESSION['error'] = $lang['error_email'] ?? 'Error';
            return false;
        }
        return true;
    }

    private function checkUpdatePass(array $lang): bool
    {
        // Hacer check (nueva pass + rep)

        if (!$this->checkPass($this->pass))
        {
            $_SESSION['error'] = $lang['error_pass'] ?? 'Error';
            return false;
        }

        if (!$this->checkPassRep($this->pass, $this->passRep))
        {
            $_SESSION['error'] = $lang['error_pass_rep'] ?? 'Error';
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