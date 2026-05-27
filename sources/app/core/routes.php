<?php

// page => [directory, controller, function]

return
[
    // Main
    'gallery' => ['main', 'GalleryController', 'gallery'],
    'photo-editor' => ['main', 'EditorController', 'editor'],

    // Auth
    'login' => ['auth', 'AuthController', 'login'],
    'signin' => ['auth', 'AuthController', 'signin'],

    // Update
    'update-user' => ['update', 'UpdateController', 'user'],
    'update-email' => ['update', 'UpdateController', 'email'],
    'update-password' => ['update', 'UpdateController', 'pass'],

    // Profile
    'user/gallery' => ['user', 'GalleryController', 'user'],
    'user/favorites' => ['user', 'GalleryController', 'favorites'],
    'user/settings' => ['user', 'SettingsController', 'settings'],

    // Others
    'send-email' => ['others', 'TokenController', 'send']
];