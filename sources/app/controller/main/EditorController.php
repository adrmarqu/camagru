<?php

require_once BACKEND . 'base/BaseController.php';

class EditorController extends BaseController
{
    public function editor()
    {
        $this->render('editor.tpl', [], []);
    }
}