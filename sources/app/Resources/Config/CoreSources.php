<?php

abstract class CoreSources
{
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