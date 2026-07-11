<?php

$lang =
[
    // Head title
    'title' =>
    [
        'login' => 'Iniciar sessión',
        'signin' => 'Registrar cuenta',
        'forgot' => 'Recuperar contraseña'
    ],

    'page' =>
    [
        'error' =>
        [
            'file' => 'Archivo: ',
            'line' => 'Línea: ',
        ],
        'form' =>
        [
            'usermail' => 'Introduce tu nombre de usuario o tu correo',
            'user' => 'Introduce tu nombre de usuario',
            'email' => 'Introduce tu correo',
            'pass' => 'Introduce tu contraseña',
            'confirm' => 'Vuelve a introducir tu contraseña',
            'terms' => 'Aceptar terminos y condiciones',
            'remember' => 'Recuerdame',
            'no_account' => '¿Aún no tienes cuenta? ',
            'create' => 'Registrate aquí'
        ]
    ],

    'btn' =>
    [
        'home' => 'Volver al inicio'
    ],

    // Not authenticated
    '401' =>
    [
        'title' => 'No autorizado',
        'message' => 'Debes iniciar sesión para acceder a este contenido.'
    ],
    // Authenticated, but you need admin
    '403' =>
    [
        'title' => 'Acceso denegado',
        'message' => 'No tienes permisos para acceder a esta página.'
    ],
    // Not found
    '404' =>
    [
        'title' => 'Página no encontrada',
        'message' => 'La página que buscas no existe o ha sido movida'
    ],
    // When you do POST, and POST doesn't exist in that route
    '405' =>
    [
        'title' => 'Método no permitido',
        'message' => 'La acción solicitada no está permitida para esta página.'
    ],
    // Internal error
    '500' =>
    [
        'title' => 'Error interno del servidor',
        'message' => 'Ha ocurrido un error inesperado. Inténtalo de nuevo más tarde.',
        'not_found' => 'El archivo de la página no existe.',
        'no_class' => 'La clase no existe: ',
        'no_method' => 'El metodo de la clase no existe: '
    ]
];

return $lang;