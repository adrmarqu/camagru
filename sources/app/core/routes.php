<?php

// page => [directory, controller, function]

return
[
    // Auth
    'login' => ['auth', 'AuthController', 'login'],
    'signin' => ['auth', 'AuthController', 'signin'],

    // Verification
    'verify-account' => ['auth', 'TokenController', 'checkAccount'],
    'verify-email' => ['auth', 'TokenController', 'checkEmail'],

    // Update user
    'update-user' => ['auth', 'UpdateController', 'user'],
    'update-email' => ['auth', 'UpdateController', 'email'],
    'update-password' => ['auth', 'UpdateController', 'password'],
    
    // Photo editor
    'photo-editor' => ['main', 'EditorController', 'editor'],

    // Gallery
    'gallery' => ['main', 'GalleryController', 'gallery'],

    // Profile
    'user/settings' => ['user', 'SettingsController', 'settings'],
    'user/favorites' => ['user', 'FavoriteController', 'favorite'],
    'user/gallery' => ['user', 'PhotoController', 'gallery'],
];