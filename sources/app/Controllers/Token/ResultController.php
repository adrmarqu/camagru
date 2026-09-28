<?php

class ResultController extends BaseController
{
    public function __invoke()
    {
        $data = [ 'css' => [ '/result.css' ]];

        $this->render('/others/result', $data);
    }
}