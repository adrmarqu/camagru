<?php

return
[
    // App core
    'gallery'           => ['controller' => 'GalleryController', 'method' => 'gallery'],
    
    'photo-editor'      => ['controller' => 'EditorController', 'method' => 'editor'],
    
    // Auth
    'login'             => ['controller' => 'AuthController', 'method' => 'login'],
    
    'signin'          => ['controller' => 'AuthController', 'method' => 'signin'],
    
    'forgot-password'   => ['controller' => 'AuthController', 'method' => 'forgot'],
    
    // User
    'profile'           => ['controller' => 'UserController', 'method' => 'profile'],
    
    'private-gallery'   => ['controller' => 'UserController', 'method' => 'privateGallery'],
    
    // Token
    'verify'            => ['controller' => 'TokenController', 'method' => 'verify'],
    
    'reset-password'    => ['controller' => 'TokenController', 'method' => 'reset']
];
