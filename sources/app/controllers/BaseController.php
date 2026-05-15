<?php

require_once VIEWS . '/View.php';

abstract class BaseController
{
    protected string    $name;
    protected string    $errors;

    protected function __construct(string $name)
    {
        $this->name = $name ?? '';
        $this->errors = $this->getFlash($name);
    }

    protected function isPost(): bool
    {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }

    protected function setFlash(string $value, ?string $path = null)
    {
        $_SESSION['flash'][$this->name] = $value;
        $this->redirect($path);
    }

    protected function getFlash($key): string
    {
        $val = $_SESSION['flash'][$key] ?? '';
        unset($_SESSION['flash'][$key]);
        return $val;
    }

    protected function redirect(?string $path = null): never
    {
        if (!$path) $path = $this->name;
        header('Location: /' . l() . '/' . $path, true, 302);
        exit();
    }

    protected function getPostData($elements): array
    {
        $data = [];
        foreach ($elements as $post)
        {
            $value = $_POST[$post] ?? '';
            $val = trim($value);

            if ($val === '') $this->setFlash(t('e.form.invalid'));
            
            $data[$post] = htmlspecialchars($val, ENT_QUOTES, 'UTF-8');
        }
        return $data;
    }




   /*  

    protected function load(string $path, string $key = '', string $msg = ''): void
    {
        if (!empty($key))
            $this->setFlash($key, $msg);
        $this->redirect($path);
    }

    private function addGlobalsVars(array $data): array
    {
        $global = 
        [ 
            'links' => '',
            'scripts' => '',

            'language' => I18n::getLanguage(),
            'page' => $this->name,

            'gallery' => t('header.gallery'),
            'editor' => t('header.editor'),
            'settings' => t('header.settings'),
            'my_gallery' => t('header.my_gallery'),
            'username' => $_SESSION['user']['username'] ?? 'Bot_1'
        ];

        return array_merge($data, $global);
    }

    private function addGlobalsIncs(array $incs): array
    {
        $css =
        [
            ['filename' => 'style.css?v=1'],
            ['filename' => 'header.css?v=1'],
            ['filename' => 'footer.css?v=1']
        ];

        if (!isset($incs['links']))
        {
            $incs['links'] =
            [
                'path' => COMPONENTS . '/link.tpl',
                'n' => 3,
                'data' => $css
            ];
        }
        else
        {
            $incs['links']['n'] += 3;
            $incs['links']['data'] = array_merge($incs['links']['data'], $css);
        }

        return $incs;
    }

    protected function render(string $screen, array $data, array $incs = [])
    {
        $data = $this->addGlobalsVars($data);
        $incs = $this->addGlobalsIncs($incs);

        $view = new View();
        $view->printHtml($screen, $data, $incs);
    } */
}