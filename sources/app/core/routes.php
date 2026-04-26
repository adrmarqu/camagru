<?php

// name page => [name controller, name function]

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
    'profile/settings' => ['profile', 'SettingsController', 'settings'],
    'profile/gallery' => ['profile', 'PhotoController', 'gallery'],

    


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