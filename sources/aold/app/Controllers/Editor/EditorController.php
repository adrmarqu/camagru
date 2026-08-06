<?php

class EditorController extends BaseController
{
    public function editor()
    {
        $this->render('/core/editor', CoreSources::editor());
    }
}