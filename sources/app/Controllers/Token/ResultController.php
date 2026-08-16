<?php

class ResultController extends BaseController
{
    public function __invoke()
    {
        $data =
        [
        ];

        $this->render('/others/result', $data);
    }
}