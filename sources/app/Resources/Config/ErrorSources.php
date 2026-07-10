<?php

abstract class ErrorSources
{
    public static function error(AppException $e)
    {
        $code = $e->getCode();
        
        return 
        [
            'code' => $code,
            'title' => Lang::t("$code.title"),
            'message' => $e->getMessage(),
            'file' => Lang::t('page.error.file'),
            'file_path' => $e->getFile(),
            'line' => Lang::t('page.error.line'),
            'line_path' => $e->getLine(),
            'link' => $e->getLink(),
            'link_label' => Lang::t('btn.home')
        ];
    }
}