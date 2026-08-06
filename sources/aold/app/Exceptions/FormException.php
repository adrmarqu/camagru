<?php

class FormException extends Exception
{
    private ?array $errors;
    private ?string $globalErr;

    public function __construct(?array $errors = null, ?string $globalErr = null)
    {
        parent::__construct('', 0);

        $this->errors = $errors;
        $this->globalErr = $globalErr;
    }

    public function getHttpError(): string
    {
        return $this->globalErr ?? '';
    }

    public function getErrors(): array
    {
        return $this->errors ?? [];
    }
}