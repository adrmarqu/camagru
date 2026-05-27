<?php

abstract class View
{
    /* Get vars to replace */
    private static function getDataScreen(string $screen, string $e): array
    {
        $header = require DATA . "/header.php";
        $main = require DATA . "/$screen.php";

        $data = array_merge($header, $main);

        $data['screen'] = $screen;
        $data['error'] = $e;
        $data['output_transparent'] = empty($e) ? 'transparent' : '';
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
    public static function render(string $screen, string $error): void
    {
        $data = self::getDataScreen($screen, $error);

        $html = self::convertTpl(LAYOUTS . '/head.tpl');
        $html .= self::convertTpl(LAYOUTS . '/header.tpl');
        $html .= self::convertTpl(SCREENS . $data['file']);
        $html .= self::convertTpl(LAYOUTS . '/footer.tpl');

        echo self::setData($html, $data); exit();
    }
}