<?php

final class Navigator
{
    private function __construct() {}
    
    /* 
        Codes:
        - 200: Normal links
        - 301: Router (clean Url)
        - 302: Temporal redirect (not logged, logged in guest pages)
    */
    public static function redirect(string $page, int $code = 200): void
    {
        $lang = Lang::getLang();

        header("Location: /$lang/$page", true, $code);
        exit;
    }

    public static function ajaxRedirection(string $page): void
    {
        $lang = Lang::getLang();
        header('Content-Type: application/json');
        echo json_encode(
        [
            'success' => true,
            'redirect' => "$lang/$page"
        ]);
        exit;
    }
}