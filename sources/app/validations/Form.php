<?php

require_once VALIDATIONS . '/Validator.php';

abstract class Form extends Validator
{
    public static function login(array $data): array
    {
        $user = $data['user'];

        Validator::addError(str_contains($user)
            ? Validator::user($user) 
            : Validator::email($user));

        Validator::addError(Validator::pass($data['pass']));

        return Validator::getErrors();
    }

    public static function signin(array $data): array
    {
        Validator::addError(Validator::user($data['user']));
        Validator::addError(Validator::email($data['email']));
        Validator::addError(Validator::pass($data['pass']));
        Validator::addError(Validator::passRep($data['pass'], $data['passRep']));
        Validator::addError(Validator::box($data['terms']));

        return Validator::getErrors();
    }
}