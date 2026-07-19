<?php

class AppException extends Exception
{
    private const DEFAULT_LINK = "/gallery";
    private string $link;
    private string $btnLabel;
    private array $errors;

    public function __construct(int $code = 0, ?string $message = null, ?string $link = null, array $errors = [])
    {
        $message = $message ?? Lang::t("$code.message");
        
        parent::__construct($message, $code);
        
        $page = $link ?? self::DEFAULT_LINK;

        $this->link = "/" . Lang::getLang() . $page;
        $this->btnLabel = substr($page, 1);
        $this->errors = $errors;
    }

    public function getLink(): string
    {
        return $this->link;
    }

    public function getBtnName(): string
    {
        return Lang::t("go.$this->btnLabel");
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}