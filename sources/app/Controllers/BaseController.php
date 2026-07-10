<?php

abstract class BaseController
{
    private $langData;

    protected function render(string $page, array $data = []): void
    {
        $view = new View();
        $view->render($page, $data);
    }
}