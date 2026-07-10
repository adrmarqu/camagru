<?php

class AuthService
{
    public function login(string $login, string $password): array
    {
        //Validator::
    }

    public function signin(string $user, string $email, string $password, string $confirm, bool $terms): array
    {
    }

    public function forgetPass(string $email): string
    {
    }

    public function resetPass(string $pass, string $rep): array
    {
    }

    public function user(string $user): string
    {

    }

    public function email(string $email): string
    {
        
    }

    public function password(string $password, string $confirm): array
    {
        
    }
}