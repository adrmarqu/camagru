<?php

class GalleryController extends BaseController
{
    public function __invoke()
    {
        $page = $_SESSION['page'] ?? 'gallery';

        if ($page === 'private-gallery') $page = 'private';
        
        $data =
        [
            'css' => [ '/gallery.css' ],
            'scripts' => [ '/gallery.js' ]
        ];

        $this->render("/core/$page", $data);
    }
}