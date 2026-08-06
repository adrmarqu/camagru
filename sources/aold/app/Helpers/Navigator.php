<?php

final class Navigator
{
    private function __construct() {}
    
    public static function redirect(string $page, $lang = null): void
    {
        $lang = $lang ?? Lang::getLang();

        $isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
        if ($isAjax) {
            header('Content-Type: application/json');
            echo json_encode([
                'success' => true,
                'redirect' => "/$lang/$page"
            ]);
            exit;
        }

        header("Location: /$lang/$page");
        exit;
    }
}