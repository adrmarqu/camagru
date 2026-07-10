<?php

abstract class CoreSources
{
    public static function editor(): array
    {
        return 
        [
            'title' => Lang::t('title.editor')
        ];
    }

    public static function gallery(): array
    {
        return 
        [
            'title' => Lang::t('title.gallery')
        ];
    }
}