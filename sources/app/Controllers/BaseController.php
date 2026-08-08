<?php

abstract class BaseController
{
    protected function render(string $tplPath, array $data): void
    {
        $view = new View();
        $view->render($tplPath, $data);
    }
}