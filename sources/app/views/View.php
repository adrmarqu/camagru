<?php

abstract class View
{
    private static function getDataScreen(string $page, string $e): array
    {
        $data = require DATA . "/$page.php";

        /* Globals */

        $data['page'] = $page;
        $data['error'] = $e;
        $data['language'] = l();
        $data['gallery'] = t('gallery');

        /* Header */
        if (isset($_SESSION['user']['user_id']))
        {
            $data['gallery'] = t('gallery');
            $data['editor'] = t('editor');
            $data['my_gallery'] = t('my_gallery');
            $data['favorite'] = t('favorite');
            $data['settings'] = t('settings');
            $data['logout'] = t('logout');
            $data['username'] = t('username');

            // Botones idiomas, marcar seleccionado
        }
        else
        {
            $data['login'] = t('login');
            $data['signin'] = t('signin');
        }
        return $data;
    }

    private static function setData(string $html, array $data): string
    {
        foreach ($data as $key => $value)
        {
            $placeholder = sprintf(TPL_PLACEHOLDER_PATTERN, $key);

            if (is_array($value))
            {
                $file = self::convertTpl($value['file']);
                $render = '';

                foreach($value['data'] as $itemData)
                    $render .= self::setData($file, $itemData);
                
                $html = str_replace($placeholder, (string)$render, $html);
            }
            else
                $html = str_replace($placeholder, (string)$value, $html);
        }
        return $html;
    }

    private static function redir($n, $a = '')
    {
        //header('Location: /' . l() . '/gallery'); exit;
        echo "Error: $n -> $a"; exit;
    }

    private static function convertTpl(string $url): string
    {
        if (!is_readable($url)) self::redir(1, $url);

        $html = file_get_contents($url);
        if ($html === false) self::redir(2);

        return $html;
    }

    public static function render(string $page, string $error): void
    {
        $data = self::getDataScreen($page, $error);

        $html = self::convertTpl(LAYOUTS . '/head.tpl');
        $html .= self::convertTpl(LAYOUTS . '/header.tpl');
        $html .= self::convertTpl(SCREENS . $data['screen']);
        $html .= self::convertTpl(LAYOUTS . '/footer.tpl');

        echo self::setData($html, $data); exit();
    }
}