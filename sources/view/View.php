<?php

const TPL_PLACEHOLDER_PATTERN = '{{::%s::}}';

class View
{
    private string  $file;
    private array   $variables = [];
    private array   $includes = [];

    public function __construct(string $file)
    {
        if (!is_readable($file))
            throw new Exception('The file $file is not readable');
        $this->file = $file;
    }

    /* Add variables that will be replaced in the end */
    public function addVariables(array $vars): void
    {
        foreach ($vars as $key => $value)
            $this->variables[$key] = $value;
    }

    /* TPL = '.../views/tpl/' */
    public function addIncludes(array $inc): void
    {
        foreach ($inc as $key => $value)
            $this->includes[$key] = COMPONENTS . $value . '.tpl';
    }

    public function getHtml(): string
    {
        /* Create header + content + footer */
        $html = $this->convertTpl(COMPONENTS . 'header.tpl');
        $html .= $this->convertTpl($this->file);
        $html .= $this->convertTpl(COMPONENTS . 'footer.tpl');

        /* Include other tpl */
        $html = $this->setIncludes($html);
        /* Replace variables */
        $html = $this->setVariables($html);
        
        return $html ?? '';
    }

    public function convertTpl(string $url): string
    {
        $html = file_get_contents($url);
        if ($html === false)
        {
            echo 'Error to open ' . $url;
            exit();
        }
        return $html ?? '';
    }

    private function setIncludes(string $html): string
    {
        foreach ($this->includes as $key => $value)
        {
            $placeholder = sprintf(TPL_PLACEHOLDER_PATTERN, $key);
            $newHtml = $this->convertTpl($value);
            $html = str_replace($placeholder, (string)$newHtml, $html);
        }
        return $html ?? '';
    }

    private function setVariables(string $html): string
    {
        foreach ($this->variables as $key => $value)
        {
            $placeholder = sprintf(TPL_PLACEHOLDER_PATTERN, $key);
            $html = str_replace($placeholder, (string)$value, $html);
        }
        return $html ?? '';
    }

    private function setOutVariables(string $html, array $data): string
    {
        foreach ($data as $key => $value)
        {
            $placeholder = sprintf(TPL_PLACEHOLDER_PATTERN, $key);
            $html = str_replace($placeholder, (string)$value, $html);
        }
        return $html ?? '';
    }

    private function getHeadFile(string $url, array $files): string
    {
        $url = $this->convertTpl($url);
        $html = '';

        foreach ($files as $fileName)
        {
            $html .= $this->setOutVariables($url, ['name' => $fileName]);
        }
        return $html;
    }

    public function getHead(string $filename, array $files): string
    {
        $link = COMPONENTS . $filename . '.tpl';
        return $this->getHeadFile($link, $files);
    }
}