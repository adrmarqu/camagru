<?php

function t(string $key)
{
    global $langText;

    $keys = explode('.', $key);
    $value = $langText;

    foreach ($keys as $k) 
    {
        if (!isset($value[$k]))
            return $key;
        $value = $value[$k];
    }
    return $value;
}