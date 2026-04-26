<?php

require_once BACKEND . 'base/BaseController.php';

class PhotoController extends BaseController
{
    public function gallery()
    {
        $this->render('photos.tpl',
        [
            
        ],
        [
            
        ]);
    }
}