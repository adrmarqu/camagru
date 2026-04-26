<?php

require_once BACKEND . 'view/View.php';

abstract class BaseController
{
    protected string    $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    protected function isPost()
    {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }
    
    protected function redirect(string $path)
    {
        header('Location: /' . t('lang') . '/' . $path, true, 302);
        exit();
    }

    protected function setFlash($key, $value)
    {
        $_SESSION['flash'][$key] = $value;
    }

    protected function getFlash($key)
    {
        $val = $_SESSION['flash'][$key] ?? '';
        unset($_SESSION['flash'][$key]);
        return $val;
    }

    /* path: new page, key: key of flash */
    protected function load(string $path, string $key = '', string $msg = ''): void
    {
        if (!empty($key))
            $this->setFlash($key, $msg);
        $this->redirect($path);
    }

    private function setGlobals(): array
    {
        return 
        [
            'language' => I18n::getLanguage(),
            'page' => $this->name
        ];
    }

    protected function render(string $screen, array $data, array $incs = [])
    {
        $view = new View();
        $view->printHtml($screen, $data, $incs);
    }
}