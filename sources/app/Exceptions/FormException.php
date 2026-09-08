<?php

class FormException extends Exception
{
    private const DEFAULT_LINK = "gallery";
    private array $errors;
    private string $link;
    private string $label;
    private ?string $redirection;

    public function __construct(int $code, ?string $msg = null, array $errors = [], ?string $link = null, ?string $redirection = null)
    {
        $message = $msg ?? Lang::t("$code.message");
        parent::__construct($message, $code);

        $lang = Lang::getLang();

        $this->label = $link ?? self::DEFAULT_LINK;
        $this->link = '/' . $lang . '/' . $this->label;
        $this->errors = $errors;
        $this->redirection = $redirection !== null ? "/$lang/$redirection" : null;
    }

    public function getLink(): string
    {
        return $this->link;
    }

    public function getRedir(): ?string
    {
        return $this->redirection;
    }

    public function getLabel(): string
    {
        return Lang::t("link.$this->label");
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}