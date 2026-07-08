<?php

class UserController extends BaseController
{
    public function profile(array $params = [])
    {
        echo "Perfil";
        exit;
    }
     
    public function privateGallery(array $params = [])
    {
        echo "Galeria privada";
        exit;
    }
}