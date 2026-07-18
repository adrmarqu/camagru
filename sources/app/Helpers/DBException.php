<?php

class DBException extends Exception
{
    private array $errors;

    public function __construct(array $errors = [])
    {
        parent::__construct("Generic message");

        $this->errors = $errors;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}