<?php

return
[
    // App core
    'gallery'           => ['controller' => 'HomeController', 'method' => 'run', 'access' => 'public'],
    
    'photo-editor'      => ['controller' => 'EditorController', 'method' => 'run', 'access' => 'user'],
    
    // Auth
    'login'             => ['controller' => 'LoginController', 'method' => 'run', 'access' => 'guest'],
    
    'signin'          => ['controller' => 'SigninController', 'method' => 'run', 'access' => 'guest'],
    
    'forgot-password'   => ['controller' => 'ForgotController', 'method' => 'run', 'access' => 'guest'],
    
    // User
    'profile'           => ['controller' => 'ProfileController', 'method' => 'run', 'access' => 'user'],
    
    'private-gallery'   => ['controller' => 'PrivateController', 'method' => 'run', 'access' => 'user'],

    'favorites'   => ['controller' => 'FavoriteController', 'method' => 'run', 'access' => 'user'],
    
    // Token
    'verify'            => ['controller' => 'VerifyController', 'method' => 'run', 'access' => 'public'],

    'result'            => ['controller' => 'VerifyController', 'method' => 'result', 'access' => 'public'],
    
    'reset-password'    => ['controller' => 'ResetController', 'method' => 'run', 'access' => 'token-reset'],

    'send-email'   => ['controller' => 'VerifyController', 'method' => 'send', 'access' => 'token-send']
];
