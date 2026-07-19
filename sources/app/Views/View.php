<?php

class View
{
    public function render(string $pageUrl, array $data = []): void
    {
        // Convert the array into local variables
        extract($data);
        // Open buffer
        ob_start();
        // import page
        $screen = PAGES_PATH . $pageUrl . '.php';
        if (file_exists($screen)) require $screen;
        else throw new AppException(500, Lang::t('500.not_found'));
        // Close buffer
        $content = ob_get_clean();
        // Main layout
        require LAYOUT_PATH . "/main.php";
    } 
}