<?php

final class CoreSources
{
    private function __construct() {}
    
    public static function gallery(): array
    {
        return 
        [
            'title' => Lang::t('title.gallery'),
            'page' => "/gallery"
        ];
    }

    public static function editor(): array
    {
        return 
        [
            'title' => Lang::t('title.editor'),
            'page' => "/photo-editor"
        ];
    }
}