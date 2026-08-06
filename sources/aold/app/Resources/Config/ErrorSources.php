<?php

final class ErrorSources
{
    private function __construct() {}
    
    public static function error(AppException $e): array
    {
        $code = $e->getCode();
        
        return 
        [
            'title' => 'Camagru | ' . $code,
            
            'code' => $code,
            'titleErr' => Lang::t("$code.title"),
            'message' => $e->getMessage(),
            'file' => Lang::t('page.error.file'),
            'file_path' => $e->getFile(),
            'line' => Lang::t('page.error.line'),
            'line_path' => $e->getLine(),
            'link' => $e->getLink(),
            'link_label' => $e->getBtnName(),
            'css' =>
            [
                '/error.css'
            ]
        ];
    }
}