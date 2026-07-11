<?php

abstract class CoreSources
{
    public static function gallery(): array
    {
        return 
        [
            'title' => Lang::t('title.gallery'),
            'page' => "/" . Lang::getLang() . "/gallery"
        ];
    }

    public static function editor(): array
    {
        return 
        [
            'title' => Lang::t('title.editor'),
            'page' => "/" . Lang::getLang() . "/photo-editor"
        ];
    }
}