<?php

class Response
{
    public static function error($code, $msg)
    {
        http_response_code($code);
        $error = new ErrorController();
        $error->render($code, $msg);
        exit;
    }

    public static function error404($lang)
    {
        $code = 404;

        http_response_code($code);
        $error = new ErrorController($lang);

        $msg = $error->getErrorText($code);
        $error->render($code, $msg);

        exit;
    }
}