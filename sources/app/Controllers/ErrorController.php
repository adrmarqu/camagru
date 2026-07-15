<?php

class ErrorController extends BaseController
{
    public function display(AppException $e): void
    {        
        http_response_code($e->getCode());
        $this->render('/error', ErrorSources::error($e));
    }
}