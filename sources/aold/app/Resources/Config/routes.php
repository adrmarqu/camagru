<?php

return
[
    // App core
    'gallery'           => ['controller' => 'HomeController', 'method' => 'run', 'access' => 'public'],
    
    'photo-editor'      => ['controller' => 'EditorController', 'method' => 'run', 'access' => 'user'],
    
    // Auth
    'login'             => ['controller' => 'LoginController', 'method' => 'run', 'access' => 'guest'],
    'api/login'         => ['controller' => 'LoginController', 'method' => 'process', 'access' => 'guest'],
    
    'signin'            => ['controller' => 'SigninController', 'method' => 'run', 'access' => 'guest'],
    'api/signin'        => ['controller' => 'SigninController', 'method' => 'process', 'access' => 'guest'],
    
    'forgot-password'   => ['controller' => 'ForgotController', 'method' => 'run', 'access' => 'guest'],
    'api/forgot'        => ['controller' => 'ForgotController', 'method' => 'process', 'access' => 'guest'],
    
    // User
    'profile'           => ['controller' => 'ProfileController', 'method' => 'run', 'access' => 'user'],
    
    'private-gallery'   => ['controller' => 'PrivateController', 'method' => 'run', 'access' => 'user'],

    'favorites'   => ['controller' => 'FavoriteController', 'method' => 'run', 'access' => 'user'],
    
    // Token
    'verify'            => ['controller' => 'VerifyController', 'method' => 'run', 'access' => 'token'],

    'result'            => ['controller' => 'VerifyController', 'method' => 'result', 'access' => 'token'],
    
    'reset-password'    => ['controller' => 'ResetController', 'method' => 'run', 'access' => 'token'],

    'send-email'   => ['controller' => 'VerifyController', 'method' => 'send', 'access' => 'token']
];
