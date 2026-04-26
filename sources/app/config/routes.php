<?php

// name page => [name controller, name function]

return
[
    // Auth
    'login' => ['auth', 'AuthController', 'login'],
    'signin' => ['auth', 'AuthController', 'signin'],

    // Verification
    'verify-account' => ['auth', 'TokenController', 'account'],
    'verify-email' => ['auth', 'TokenController', 'email'],
    
    // Photo editor
    'photo-editor' => ['main', 'EditorController', 'editor'],

    // Gallery
    'gallery' => ['main', 'GalleryController', 'gallery'],

    // Profile
    'profile/settings' => ['profile', 'SettingsController', 'settings'],
    'profile/gallery' => ['profile', 'PhotoController', 'gallery'],

    // Update user
    'update-user' => ['profile', 'UpdateController', 'user'],
    'update-email' => ['profile', 'UpdateController', 'email'],
    'update-password' => ['profile', 'UpdateController', 'password'],


    // Profile

    /* 
    
        Configuracion
            - Datos de la cuenta (poder cambiarlos)
            - Activar o no notificaciones
            - Eliminar cuenta (usuario + pass + id)

        Galeria de fotos subidas (las preview)
            - Al seleccionar una imagen
                - Foto completa
                - Comentarios
                - Likes
                - Eliminar foto
                - Descargar foto
        
    */
];