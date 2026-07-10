<?php

class ErrorController extends BaseController
{
    public function display(AppException $e): void
    {        
        $this->render('/error', ErrorSources::error($e));
    }
}