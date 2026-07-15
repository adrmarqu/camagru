<?php

abstract class BaseController
{
    protected function render(string $page, array $data = []): void
    {
        // Merge global and page data
        $sources = array_merge(GlobalSources::all(), $data);

        $view = new View();
        $view->render($page, $sources);
    }
}