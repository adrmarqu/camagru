<?php

abstract class GlobalSources
{
    /* Global vars */
    public static function all(): array
    {
        return
        [
            /* Global */
            'lang' => Lang::getLang(),
            'css' =>
            [
                '/header.css',
                '/error.css'
            ],

            /* Header */
            'logged' => isset($_SESSION['user']),

            /* Footer */
        ];
    }
}