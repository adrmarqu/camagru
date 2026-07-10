<?php

abstract class BaseController
{
    private $langData;

    public function __construct($lang)
    {
        LangService::setLang($lang);
    }

    protected function render(array $data): void
    {
        $view = new View();
        $view->render($data);
    }
}