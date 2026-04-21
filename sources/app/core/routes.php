<?php

return
[
    // Auth
    'login' => [AuthController::class, 'login'],
    'signin' => [AuthController::class, 'signin'],

    // Verification
    'verification' => [CodeController::class, 'verification'],

    // Update user
    'update-user' => [UpdateController::class, 'user'],
    'update-email' => [UpdateController::class, 'email'],
    'update-password' => [UpdateController::class, 'password'],

    // Photo editor
    'photo-editor' => [EditorController::class, 'editor'],

    // Gallery
    'gallery' => [GalleryController::class, 'gallery'],

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