<?php

require_once BACKEND . 'validation/FormValidation.php';
require_once BACKEND . 'view/View.php';

class BaseController
{
    protected function isPost()
    {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }
    
    protected function redirect(string $path)
    {
        header('Location: /' . t('lang') . '/' . $path, true, 302);
        exit();
    }

    protected function render(string $screen, array $data, array $incs = [])
    {
        $view = new View($screen);
        
        // CSS
        if (isset($data['links']) && !empty($data['links']))
            $data['links'] = $view->getHead('link', $data['links']);

        // JS
        if (isset($data['scripts']) && !empty($data['scripts']))
            $data['scripts'] = $view->getHead('script', $data['scripts']);

        // Save data
        $view->addVariables($data);
        $view->addIncludes($incs);

        // Get html
        echo $view->getHtml();
        exit();
    }
}