<?php

require_once BACKEND . 'base/BaseController.php';

class GalleryController extends BaseController
{
    public function gallery()
    {
        $this->render('gallery.tpl', [], []);
    }
}