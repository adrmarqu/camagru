<?php

abstract class View
{
    /* Get vars to replace */
    private static function getDataScreen(string $page, string $e): array
    {
        $header = require DATA . "/header.php";
        $main = require DATA . "/$page.php";

        $data = array_merge($header, $main);

        $data['page'] = $page;
        $data['error'] = $e;
        $data['language'] = l();

        return $data;
    }

    /* Replace vars */
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

    /* In case of error redirect */
    private static function redir($n, $a = '')
    {
        //header('Location: /' . l() . '/gallery'); exit;
        echo "Error: $n -> $a"; exit;
    }

    /* Get the template */
    private static function convertTpl(string $url): string
    {
        if (!is_readable($url)) self::redir(1, $url);

        $html = file_get_contents($url);
        if ($html === false) self::redir(2);

        return $html;
    }

    /* Join the templates in one and show them in the frontend */
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