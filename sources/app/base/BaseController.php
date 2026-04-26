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
            ['filename' => 'style.css'],
            ['filename' => 'header.css?v=1'],
            ['filename' => 'footer.css']
        ];

        if (!isset($incs['links']))
        {
            $incs['links'] =
            [
                'path' => COMPONENTS . 'link.tpl',
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
    }
}