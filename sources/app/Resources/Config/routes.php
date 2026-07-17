<?php

return
[
    // App core
    'gallery'           => ['controller' => 'GalleryController', 'method' => 'gallery', 'access' => 'public'],
    
    'photo-editor'      => ['controller' => 'EditorController', 'method' => 'editor', 'access' => 'user'],
    
    // Auth
    'login'             => ['controller' => 'AuthController', 'method' => 'login', 'access' => 'guest'],
    
    'signin'          => ['controller' => 'AuthController', 'method' => 'signin', 'access' => 'guest'],
    
    'forgot-password'   => ['controller' => 'AuthController', 'method' => 'forgot', 'access' => 'guest'],
    
    // User
    'profile'           => ['controller' => 'UserController', 'method' => 'profile', 'access' => 'user'],
    
    'private-gallery'   => ['controller' => 'UserController', 'method' => 'privateGallery', 'access' => 'user'],

    'favorites'   => ['controller' => 'UserController', 'method' => 'favorites', 'access' => 'user'],
    
    // Token
    'verify'            => ['controller' => 'TokenController', 'method' => 'verify', 'access' => 'public'],
    
    'reset-password'    => ['controller' => 'TokenController', 'method' => 'reset', 'access' => 'token-reset'],

    'send-email'   => ['controller' => 'TokenController', 'method' => 'send', 'access' => 'token-send']
];
