<?php

return
[
    // App core
    'gallery' =>
    [
        'controller' => 'HomeController', 
        'access' => 'public'
    ],
    
    'photo-editor' => 
    [
        'controller' => 'EditorController', 
        'access' => 'private'
    ],
    
    // Auth
    'login' => 
    [
        'controller' => 'LoginController', 
        'access' => 'guest'
    ],
    
    'signin' => 
    [
        'controller' => 'SigninController', 
        'access' => 'guest'
    ],
    
    'forgot-password' => 
    [
        'controller' => 'ForgotController', 
        'access' => 'guest'
    ],

    // User
    'profile' => 
    [
        'controller' => 'ProfileController', 
        'access' => 'private'
    ],
    
    'private-gallery' => 
    [
        'controller' => 'PrivateController', 
        'access' => 'private'
    ],

    'favorites' => 
    [
        'controller' => 'FavoriteController', 
        'access' => 'private'
    ],
    
    // Token
    'verify' => 
    [
        'controller' => 'VerifyController', 
        'access' => 'token',
        'token' => 'verify'
    ],

    'result' => 
    [
        'controller' => 'ResultController', 
        'access' => 'token'
        'token' => 'result'
    ],
    
    'reset-password' => 
    [
        'controller' => 'ResetController', 
        'access' => 'token',
        'token' => 'reset'
    ],

    'send-email' => 
    [
        'controller' => 'SendController', 
        'access' => 'token',
        'token' => 'send'
    ]
];
