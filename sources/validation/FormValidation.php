<?php

class FormValidation
{
    public function checkSignin($user, $email, $pass, $passRep, $terms): string
    {
        $error = '';
        $checks = 
        [
            fn() => $this->user($user),
            fn() => $this->email($email),
            fn() => $this->pass($pass),
            fn() => $this->passRep($passRep),
            fn() => $this->terms($terms)
        ];

        foreach ($checks as $check)
        {
            $error = $check();
            if ($error !== '') break;
        }
        return $error;
    }

    public function checkUser(string $user): string
    {
        return preg_match('/^[a-zA-Z][a-zA-Z0-9_]{3,20}$/', $user) ? '' : t('errors.form.user');
    }

    public function checkEmail(string $email): string
    {
        return preg_match('/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/', $email) ? '' : t('errors.form.email');
    }

    public function checkPass(string $pass): string
    {
        return preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/', $pass) ? '' : t('errors.form.pass');
    }

    public function checkPassRep(string $pass, string $rep): string
    {
        return $pass === $rep ? '' : t('errors.form.pass_rep');

    }

    public function checkTerms(bool $terms): string
    {
        return $terms ? '' : t('errors.form.terms');
    }
}