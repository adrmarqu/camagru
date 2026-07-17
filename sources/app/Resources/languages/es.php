<?php

$lang =
[
    // Head title
    'title' =>
    [
        // main
        'gallery' => 'Galeria',
        'editor' => 'Editor de fotos',
        // auth
        'login' => 'Iniciar sessión',
        'signin' => 'Registrar cuenta',
        'forgot' => 'Recuperar contraseña',
        // user
        'profile' => 'Mi perfil',
        'private' => 'Mi galeria',
        'favorites' => 'Mis favoritos',
        // token
        'send' => 'Enviar email',
        'verify' => 'Verificación'
    ],

    'header' =>
    [
        'gallery' => 'Galeria',
        'editor' => 'Editor de fotos',
        'logout' => 'Desconectarse',
        'profile' => 'Perfil',
        'private' => 'Mi galeria',
        'favorite' => 'Mis favoritos',
        'login' => 'Iniciar sessión',
        'signin' => 'Registrarse',
        'en' => 'Inglés',
        'es' => 'Español',
        'ca' => 'Catalán',
        'guest' => 'Invitado'
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
            'email_block' => 'Correo introducido',
            'password' => 'Introduce tu contraseña',
            'confirm' => 'Vuelve a introducir tu contraseña',
            'terms' => 'Aceptar terminos y condiciones',
            'remember' => 'Recuerdame',
            'no_account' => '¿Aún no tienes cuenta? ',
            'create' => 'Registrate aquí',
            'forgot' => '¿Has olvidado tu contraseña? ',
            'reset' => 'Reiniciala aqui',

            'placeholder' =>
            [
                'user' => 'Usuario',
                'email' => 'Correo electrónico',
                'usermail' => 'Usuario o Correo electrónico',
                'password' => 'Contraseña',
                'new_password' => 'Contraseña nueva',
                'confirm' => 'Confirmar contraseña',
                'new_confirm' => 'Confirmar contraseña nueva'
            ]
        ]
    ],

    'btn' =>
    [
        'home' => 'Volver al inicio',
        'send' => 'Enviar',
        'email' => 'Enviar correo'
    ],

    'error' =>
    [
        'empty' =>
        [
            'user' => 'El usuario está vacio',
            'usermail' => 'El usuario o correo está vacio',
            'email' => 'El correo está vacio',
            'password' => 'La contraseña está vacia',
            'confirm' => 'La confirmación de la contraseña está vacia'
        ],

        'length' =>
        [
            'user' => 'El nombre de usuario debe tener entre 3 y 20 caracteres.',
            'email' => 'El correo es demasiado grande para la base de datos.',
            'password_8' => 'La contraseña debe tener al menos 8 carácteres.',
            'password_72' => 'La contraseña no puede tener más de 72 carácteres.'
        ],

        'bbdd' =>
        [
            'exist' =>
            [
                'user' => 'Ese usuario ya está en uso',
                'email' => 'Ese correo ya está en uso'
            ]
        ],

        'user' => 'El usuario debe empezar por una letra, además solo puede contener letras, números y guiones.',
        'email' => 'El correo electrónico no es válido.',
        'password' => 'La contraseña ha de tener al menos una minúscula, una mayúscula y un número.',

        'confirm' => 'La contraseña es diferente',

        'terms' => 'Para crear una cuenta necesitas aceptar los terminos y condiciones',

    ],

    'go' =>
    [
        'gallery' => 'Volver a la Galeria',
        'login' => 'Iniciar sesión',
        'profile' => 'Volver a tu perfil',
    ],

    // Bad request
    '400' =>
    [
        'title' => 'Petición incorrecta',
        'message' => 'La solicitud no pudo ser procesada o es inválida.'
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
        'message' => 'No tienes permisos para acceder a esta página.',
        'no_token' => 'Necesitas un token para acceder a esta página.'
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
    // Conflict
    '409' =>
    [
        'title' => 'Conflicto',
        'message' => 'Hubo un conflicto al procesar la solicitud (ej. el recurso ya existe).'
    ],
    // Unprocessable Entity
    '422' =>
    [
        'title' => 'Datos no válidos',
        'message' => 'Los datos enviados no son válidos o están incompletos.'
    ],
    // Internal error
    '500' =>
    [
        'title' => 'Error interno del servidor',
        'message' => 'Ha ocurrido un error inesperado. Inténtalo de nuevo más tarde.',
        'not_found' => 'El archivo de la página no existe.',
        'no_class' => 'Clase inexistente: ',
        'no_method' => 'Método de clase inexistente: ',
        'no_access' => 'Acceso inexistente: '
    ]
];

return $lang;