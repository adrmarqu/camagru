<?php

abstract class BaseController
{
    protected function render(string $pageUrl, array $data = []): void
    {
        $global = GlobalSources::globalData();
        $header = GlobalSources::header();
        //$footer = GlobalSources::foter();

        $sources = array_merge($global, $header, $data);

        $view = new View();
        $view->render($pageUrl, $sources);
    }
}