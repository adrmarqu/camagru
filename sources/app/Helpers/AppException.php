<?php

class AppException extends Exception
{
    private const DEFAULT_LINK = "/gallery";
    private string $link;

    public function __construct(int $code, ?string $message = null, ?string $link = null)
    {
        $message = $message ?? Lang::t("$code.message");
        parent::__construct($message, $code);
        $this->link = $link ?? self::DEFAULT_LINK;
    }

    public function getLink(): string
    {
        return "/" . Lang::getLang() . $this->link;
    }
}