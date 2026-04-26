<?php

class View
{
    private function convertTpl(string $url): string
    {
        if (!is_readable($url))
            throw new Exception("The file {$url} is not readable");
        
        $html = file_get_contents($url);
        if ($html === false)
        {
            echo 'Error to open ' . $url;
            exit();
        }
        return $html;
    }

    private function setIncludes(string $html, array $incs): string
    {
        foreach ($incs as $tag => $config)
        {
            $path = $config['path'];
            $n = (int)$config['n'];
            $data = $config['data'];

            $replacement = '';

            if (file_exists($path))
            {
                $tplContent = $this->convertTpl($path);

                if ($n === 0)
                    $replacement = $tplContent;
                else
                {
                    for ($i = 0; $i < $n; $i++)
                    {
                        $current = $tplContent;
                        if (isset($data[$i]) && is_array($data[$i]))
                        {
                            foreach ($data[$i] as $varKey => $value)
                            {
                                $placeholder = sprintf(TPL_PLACEHOLDER_PATTERN, $varKey);
                                $current = str_replace($placeholder, $value, $current);
                            }
                        }
                        $replacement .= $current;
                    }
                }
            }

            $tagToSearch = sprintf(TPL_PLACEHOLDER_PATTERN, $tag);
            $html = str_replace($tagToSearch, $replacement, $html);
        }
        return $html;
    }

    private function setVariables(string $html, array $data)
    {
        foreach ($data as $key => $value)
        {
            $placeholder = sprintf(TPL_PLACEHOLDER_PATTERN, $key);
            $html = str_replace($placeholder, $value, $html);
        }
        return $html;
    }

    public function printHtml(string $screen, array $data, array $incs = []): void
    {
        $html = $this->convertTpl(GLOBALS . 'head.tpl');
        $html .= $this->convertTpl(GLOBALS . 'header.tpl');
        $html .= $this->convertTpl(SCREENS . $screen);
        $html .= $this->convertTpl(GLOBALS . 'footer.tpl');

        /* Include other tpl */
        $html = $this->setIncludes($html, $incs);
        /* Replace variables */
        $html = $this->setVariables($html, $data);

        echo $html; exit();
    }
}