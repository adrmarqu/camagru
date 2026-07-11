<?php

abstract class BaseController
{
    private $langData;

    protected function render(string $page, array $data = []): void
    {
        // Fusionar datos
        $sources = array_merge(GlobalSources::all(), $data);

        $view = new View();
        $view->render($page, $sources);
    }
}