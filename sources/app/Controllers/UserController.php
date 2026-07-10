<?php

class UserController extends BaseController
{
    public function profile()
    {
        $this->render('/user/profile', UserSources::profile());
    }
     
    public function privateGallery(array $params = [])
    {
        $this->render('/user/gallery', UserSources::gallery());
    }
}