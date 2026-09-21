<?php

class GalleryController extends BaseController
{
    public function __invoke()
    {
        $page = $_SESSION['page'] ?? 'gallery';

        if ($page === 'private-gallery') $page = 'private';
        echo $page;
        
        $this->render("/core/$page");
    }
}