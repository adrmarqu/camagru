<?php

class EditorController extends BaseController
{
    public function __invoke()
    {
        $data =
        [
        ];

        $this->render('/core/editor', $data);
    }
}