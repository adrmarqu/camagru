<?php

class GalleryController extends BaseController
{
    public function gallery(array $params = [])
    {
        $this->render('/core/gallery', CoreSources::gallery());
    }
}