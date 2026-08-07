<?php

class HttpException extends Exception
{
    private string $link;
    private string $btnLabel;

    public function __construct(int $code = 0, ?string $message = null, string $link = '/gallery')
    {
        $message = $message ?? Lang::t("$code.message");
        
        parent::__construct($message, $code);
        
        /* Btn link */
        $this->link = "/" . Lang::getLang() . $link;

        /* Btn text */
        $this->btnLabel = substr($link, 1);
    }

    public function getLink(): string
    {
        return $this->link;
    }

    public function getBtnName(): string
    {
        return Lang::t("btn.$this->btnLabel");
    }
}