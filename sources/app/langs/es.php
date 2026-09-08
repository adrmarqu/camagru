<?php

$year = date("Y");

$lang =
[
    'title' =>
    [
        // Core
        'gallery' => 'Galeria',
        'editor' => 'Editor de fotos',
        // Auth
        'login' => 'Iniciar sessión',
        'signin' => 'Registrar usuario',
        'forgot' => 'Recuperar contraseña',
        // User
        'profile' => 'Perfil',
        'favorites' => 'Favoritos',
        'private-gallery' => 'Mi galeria',
        // Token
        'verify' => 'Verificación',
        'result' => 'Resultado',
        'reset-password' => 'Restaurar contraseña',
        'send-email' => 'Enviar email'
    ],

    'es' => 'Español',
    'ca' => 'Catalán',
    'en' => 'Inglés',

    'header' =>
    [
        'gallery' => 'Galeria',
        'editor' => 'Editor de fotos',
        'login' => 'Iniciar sesión',
        'signin' => 'Registrarse',
        'profile' => 'Perfil',
        'favorites' => 'Mis favoritos',
        'private' => 'Mi galeria',
        'logout' => 'Desconectarse',
        'languages' => 'Idiomas'
    ],

    'link' =>
    [
        'gallery' => 'Volver a la galeria'
    ],

    'db' =>
    [
        'exists' =>
        [
            'user' => 'Ese usuario ya está en uso',
            'email' => 'Ese correo ya está en uso'
        ]
    ],

    'form' =>
    [
        'label' =>
        [
            'usermail' => 'Usuario o Correo electrónico',
            'user' => 'Usuario',
            'email' => 'Correo electrónico',
            'pass' => 'Contraseña',
            'conf' => 'Confirmar contraseña',
        ],
        // Placeholder
        'ph' =>
        [
            'usermail' => 'Usuario o Correo electrónico',
            'user' => 'Usuario',
            'email' => 'Correo electrónico',
            'pass' => 'Contraseña',
            'conf' => 'Repetir contraseña',
            'new' => 'Nueva contraseña',
            'confi' => 'Repetir contraseña nueva',
            'curr' => 'Contraseña actual'
        ],
        // Errors
        'error' =>
        [
            'user' => 'Usuario debe empezar por una letra y solo puede tener letras, números y guiones',
            'email' => 'El correo ha de ser válido',
            'pass' => 'La contraseña ha de tener 8-72 caracteres, una majúscula, un minúscula y un número',
            'conf' => 'Las contraseñas són diferentes'
        ],
        // Error void
        'void' => 'Este campo es obligatorio'
    ],

    'login' =>
    [
        'title' => 'Iniciar sessión',
        'intro' => 'Bienvenido de vuelta.',
        'remember' => 'Recuerdame',
        'no_account' => '¿No tienes cuenta? ',
        'new' => 'Registrate',
        'forgot' => '¿Has olvidado tu contraseña? ',
        'reset' => 'Recuerdala'
    ],

    'signin' =>
    [
        'title' => 'Registrar usuario',
        'intro' => 'Bienvenido a Camagru',
        'terms' => 'Terminos y condiciones',
        'account' => '¿Ya tienes cuenta? ',
        'log' => 'Inicia sesión',
        'no_terms' => 'Debes aceptar los terminos y condiciones'
    ],

    'forgot' =>
    [
        'title' => 'Olvidar contraseña',
        'intro' => 'Introduce el correo de tu cuenta',
        'message' => '¡He recordado mi contraseña! ',
        'login' => 'Inicia sessión'    
    ],

    'send' =>
    [
        'title' => 'Enviar correo',
        'intro' => 'Puedes volver a enviar un correo',
        'message' => '¡Ya no lo necesito! ',
        'home' => 'Ir a la galeria'
    ],

    'reset' =>
    [
        'title' => 'Restaura contraseña',
        'intro' => 'Introduce tu nueva contraseña',
        'message' => '¡No quiero cambiar de contraseña! ',
        'login' => 'Inicia sessión'
    ],

    'result' =>
    [
        'account' => '¡Felicidades! <br><br> Tu cuenta ya ha sido activada. Ya puedes iniciar sesión en Camagru',
        'email' => '¡Felicidades! <br><br> Tu nuevo correo electrónico ha sido actualizado con exito.',
        'reset' => '¡Felicidades! <br><br> Tu contraseña ha sido restaurada con exito.'
    ],

    'profile' =>
    [
        'danger' =>
        [
            'title' => 'Zona de peligro',
            'delete' => 'Eliminar tu cuenta',
            'sure' => '¿Estás seguro de que quieres eliminar la cuenta?',
            'confirm' => 'Está acción es irreversible, una vez eliminada la cuenta no la podrás volver a recuperar. Además, se eliminarán todas tus fotos, comentarios y likes de Camagru. Pulsa el botón cancelar para volver atrás al perfil.',
            'pass' => 'Introduce tu contraseña para confirmar'
        ],
        'noti' =>
        [
            'title' => 'Preferencias',
            'label' => 'Recibir notificaciones por correo electrónico'
        ],
        'stats' =>
        [
            'change_photo' => 'Cambiar avatar',
            'title' => 'Estadísticas',
            'photos' => 'Fotos subidas',
            'likes' => 'Likes recibidos',
            'comments' => 'Comentarios recibidos'
        ],
        'security' =>
        [
            'title' => 'Seguridad',
            'curr' => 'Contraseña actual',
            'new' => 'Nueva contraseña',
            'conf' => 'Confirmar nueva contraseña'
        ],
        'info' =>
        [
            'title' => 'Información',
            'user' => 'Nombre de usuario'
        ]
    ],

    'btn' =>
    [
        'send' => 'Enviar',
        'cancel' => 'Cancelar',
        'delete' => 'Eliminar cuenta',
        'update' => 'Actualizar',
        'edit' => 'Editar',

        'gallery' => 'Volver a la Galeria',
        'login' => 'Iniciar sesión',
        'profile' => 'Volver a tu perfil'
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

        'reset' =>
        [
            'subject' => 'Restablece tu contraseña',
            'title' => 'Recuperar contraseña',
            'link' => 'Restablecer contraseña',
            'body' => 'No te preocupes, nos pasa a todos. Haz clic en el botón de abajo para elegir una nueva contraseña de forma segura. Ten en cuenta que, por motivos de seguridad, este enlace caducará en 5 minutos. Para generar un nuevo enlace, simplemente vuelve a la página de /forgot-password y envia otro correo.'
        ],

        'footer' => "Este es un correo automático, por favor no respondas a este mensaje. Si tienes problemas o no has solicitado este correo, ponte en contacto con soporte. © $year Camagru. Todos los derechos reservados."
    ],

    '200' =>
    [
        'user' => 'Nombre de usuario actualizado con exito.',
        'email' => 'Se ha enviado un correo electrónico para confirmar el nuevo email.',
        'usermail' => 'Usuario actualizado con exito. Correo de confirmación enviado a tu nuevo correo.',
        'pass' => 'La contraseña se ha actualizado con exito.',
        'noti' => 'Preferencias actualizadas con exito.'
    ],
    // Bad request
    '400' =>
    [
        'title' => 'Petición incorrecta',
        'message' => 'La solicitud no pudo ser procesada o es inválida.',
        'corrupt_url' => 'Camagru no puede leer esa URL (URL corrupta)'
    ],
    // Not authenticated
    '401' =>
    [
        'title' => 'No autorizado',
        'message' => 'Debes iniciar sesión para acceder a este contenido.',
        'login' => 'Usuario, correo o contraseña incorrectos.'
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
        'action' => 'Ese tipo formulario no existe',
        'no_token' => 'El token no existe o ha expirado',
        'no_file' => 'Ese archivo no existe en esa ruta',
        'get' => 'El query introducido no existe en Camagru'
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
        'message' => 'Hubo un conflicto al procesar la solicitud (ej. el recurso ya existe en la base de datos).',
        'pass' => 'La nueva contraseña debe ser diferente a la actual'
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
        'message' => 'Los datos enviados no son válidos o están incompletos.',
        'pass' => 'Contraseña incorrecta'
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
        'token' => 'No se ha podido crear un token. Por favor, inténtalo de nuevo más tarde.',
        'send' => 'Ha habido un problema al enviar el email.',
        'db' => 'Error en la base de datos.',
        'delete_token' => 'No se ha podido eliminar el token.',
        'activate' => 'No se ha podido activar la cuenta.',
        'change_email' => 'No se ha podido actualizar el email.',
        'type' => 'Ese tipo de token no existe.',
        'update_pass' => 'No se ha podido actualizar la contraseña',
        'delete' => 'No se ha podido eliminar la cuenta.'
    ],

    'footer' =>
    [
        'rights' => 'Todos los derechos reservados.',
        'developed' => 'Desarrollado con ❤️ para',
        'web' => 'Mi sitio web'
    ]
];

return $lang;