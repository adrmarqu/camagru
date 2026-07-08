<?php

abstract class BaseController
{
    private $langData;

    public function __construct($lang)
    {
        $path = LANG_PATH . "/$lang.php";

        if (file_exists($path))
            $this->langData = require $path;
        else
            $this->langData = require APP_PATH . "/en.php";
    }

    protected function t(string $key): string
    {
        return $this->langData[$key] ?? $key;
    }
}