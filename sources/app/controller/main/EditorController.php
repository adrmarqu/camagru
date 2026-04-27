<?php

require_once BACKEND . 'base/BaseController.php';

class EditorController extends BaseController
{
    public function editor()
    {
        $this->render('editor.tpl', [],
        [
            'scripts' =>
            [
                'path' => COMPONENTS . 'script.tpl',
                'n' => 1,
                'data' => [['filename' => 'webcam.js?v=1']]
            ],
        ]);
    }
}