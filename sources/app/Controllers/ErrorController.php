<?php

class ErrorController extends BaseController
{
    public function render($code, $msg)
    {
        echo "Error $code: $msg";
        exit;
    }

    public function getErrorText($code)
    {
        return $this->t($code);
    }
}