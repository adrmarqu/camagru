<?php

class DBException extends Exception
{
    private const DEFAULT_LINK = "/gallery";
    private string $link;
    private string $btnLabel;

    public function __construct(int $code = 0, ?string $message = null, ?string $link = null)
    {
        $message = $message ?? Lang::t("$code.message");
        
        parent::__construct($message, $code);
        
        /* Btn link */
        $page = $link ?? self::DEFAULT_LINK;
        $this->link = "/" . Lang::getLang() . $page;

        /* Btn text */
        $this->btnLabel = substr($page, 1);
    }

    public function getLink(): string
    {
        return $this->link;
    }

    public function getBtnName(): string
    {
        return Lang::t("go.$this->btnLabel");
    }
}