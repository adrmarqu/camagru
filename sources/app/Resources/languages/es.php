<?php

$year = date("Y");

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
        'verify_account' => 'Verificar cuenta',
        'verify_email' => 'Verificar email',
        'reset' => 'Restaurar contraseña'
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
            'account' => '¿Ya tienes una cuenta? ',
            'login' => 'Inicia sesión',
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

    'send_body' => 'Email enviado',

    'verify' =>
    [
        'account' => '¡Felicidades! <br><br> Tu cuenta ha sido activada y ya puedes iniciar sesión en Camagru',
        'email' => '¡Felicidades! <br><br> Tu nuevo correo electrónico ha sido actualizado con exito.'
    ],

    'email' =>
    [
        'account' =>
        [
            'subject' => '¡Te damos la bienvenida a Camagru! Activa tu cuenta',
            'title' => 'Activación de cuenta',
            'link' => 'Activar mi cuenta',
            'body' => 'Gracias por registrarte en Camagru. Para empezar a usar tu cuenta y disfrutar de todas las funciones, por favor actívala pulsando el botón de abajo. Ten en cuenta que el enlace caducará en 30 minutos. Para solicitar un nuevo enlace, vuelve a /send-email y envia un nuevo correo. También puedes iniciar sesión con tu cuenta para recibir un nuevo correo.'
        ],
        'email' =>
        [
            'subject' => 'Confirma tu nuevo email',
            'title' => 'Confirmación de email',
            'link' => 'Confirmar nuevo email',
            'body' => 'Camagru ha recibido una solicitud para cambiar tu dirección de correo. Si has sido tú, haz clic en el botón de abajo para confirmar el cambio. Si no has solicitado este cambio, puedes ignorar este mensaje de forma segura. Ten en cuenta que el enlace caducará en 10 minutos. Para volver a enviar un nuevo enlace, vuelve a la página de /send-email, o vuelve a cambiar tu correo desde tu perfil.'
        ],
        'password' =>
        [
            'subject' => 'Restablece tu contraseña',
            'title' => 'Recuperar contraseña',
            'link' => 'Restablecer contraseña',
            'body' => 'No te preocupes, nos pasa a todos. Haz clic en el botón de abajo para elegir una nueva contraseña de forma segura. Ten en cuenta que, por motivos de seguridad, este enlace caducará en 5 minutos. Para generar un nuevo enlace, simplemente vuelve a la página de /forgot-password y envia otro correo.'
        ],
        'footer' => "Este es un correo automático, por favor no respondas a este mensaje. Si tienes problemas o no has solicitado este correo, ponte en contacto con soporte. © $year Camagru. Todos los derechos reservados."
    ],

    'error' =>
    [
        'empty' =>
        [
            'user' => 'El usuario está vacio',
            'usermail' => 'El usuario o el correo están vacios',
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

        'exists' =>
        [
            'user' => 'Ese usuario ya está en uso',
            'email' => 'Ese correo ya está en uso'
        ],

        'form' =>
        [
            /* Login */
            'log_user' => 'El usuario o correo es incorrecto.',
            'log_pass' => 'La contraseña es incorrecta',
            /* Signin */
            'user' => 'El usuario debe empezar por una letra, además solo puede contener letras, números y guiones.',
            'email' => 'El correo electrónico no es válido.',
            'password' => 'La contraseña ha de tener al menos una minúscula, una mayúscula y un número.',
            'confirm' => 'La contraseña es diferente',
            'terms' => 'Para crear una cuenta necesitas aceptar los terminos y condiciones',
            /* Forgot */
            /* Profile */
        ],

        'send' => 'Error al enviar el correo',
        'remember' => 'Error al crear la cookie "remember_me".'
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
        'message' => 'Debes iniciar sesión para acceder a este contenido.',
        'pass' => 'Contraseña incorrecta.'
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
        'message' => 'La página que buscas no existe o ha sido movida',
        'no_token' => 'El token no existe o ha expirado',
        'user' => 'El usuario no existe.',
        'email' => 'El email no existe.',
        'usermail' => 'El usuario o el email no existe.'
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
        'message' => 'Hubo un conflicto al procesar la solicitud (ej. el recurso ya existe en la base de datos).'
    ],
    // Conflict
    '410' =>
    [
        'title' => 'Ya no disponible',
        'message' => 'El recurso solicitado ya no está disponible y ha sido eliminado permanentemente (ej. el enlace ha expirado).'
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
        'no_access' => 'Acceso inexistente: ',
        'signin' => 'No se ha podido crear el usuario. Por favor, inténtalo de nuevo más tarde.',
        'token' => 'No se ha podido crear un token. Por favor, inténtalo de nuevo más tarde.'
    ]
];

return $lang;