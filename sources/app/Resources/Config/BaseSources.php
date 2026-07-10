<?php

abstract class BaseSources
{
    protected static function t($key)
    {
        return LangService::t($key);
    }
}