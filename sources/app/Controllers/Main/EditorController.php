<?php

class EditorController extends BaseController
{
    public function __invoke()
    {
        $data = 
        [
            'css' => [ '/editor.css' ],
            'scripts' => [ '/editor/editor.js' ]
        ];
        $this->render('/core/editor', $data);
    }
}