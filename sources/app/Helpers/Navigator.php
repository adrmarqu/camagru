<?php

final class Navigator
{
    private function __construct() {}
    
    /* 
        HTTP Status Codes:
        - 200: Normal links
        - 301: Permanent redirect (clean sanitized URL)
        - 302: Temporary redirect (auth / guest protection)
    */
    public static function redirect(string $page, int $code = 200): void
    {
        $lang = Lang::getLang();

        header("Location: /$lang/$page", true, $code);
        exit;
    }

    public static function ajaxRedirection(string $page, int $code = 200): void
    {
        $lang = Lang::getLang();
        $page = ltrim($page, '/');

        http_response_code($code);
        header('Content-Type: application/json');
        echo json_encode(
        [
            'success' => $code >= 200 && $code < 300,
            'redirect' => "/$lang/$page"
        ]);
        exit;
    }
}