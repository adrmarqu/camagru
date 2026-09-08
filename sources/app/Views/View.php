<?php

final class View
{
    private string $file;

    public function render(string $tplPath, array $sources = []): void
    {
        $this->file = VIEW_PATH . $tplPath . '.php';
        
        if (!file_exists($this->file))
            throw new HttpException(404, Lang::t('404.no_file'));
        
        extract($sources);
        require LAYOUT_TPL . '/main.php';
    }
}