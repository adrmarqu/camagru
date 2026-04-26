<?php

return
[
    'form' =>
    [
        'usermail' => 'Usuario/Correo',
        'user' => 'Usuario',
        'new_user' => "Nuevo usuario",

        'email' => 'Correo electronico',
        'new_email' => 'Nuevo correo electronico',

        'terms' => 'He leido y aceptado los terminos y condiciones',

        'pass' => 'Contraseña',
        'new_pass' => 'Nueva contraseña',
        'curr_pass' => 'Contraseña actual',
        'rep_pass' => 'Repite contraseña',

        'del' => 'Borrar',
        'send' => 'Enviar',

        'verification' => 'Código de verificación'
    ],

    'errors' =>
    [
        'form' =>
        [
            'format' => 'Este tipo de formulario no existe',
            
            'user' => 'El usuario debe de empezar por una letra y solo puede contener letras, numeros y guiones bajos. Ademas debe de ser de 3 a 20 caracteres',
            
            'email' => 'El correo es incorrecto, debe de ser: text@text.text',
            
            'pass' => 'La contraseña ha de tener al menos una letra minuscula, una mayuscula, un numero y 8-100 caracteres',
            
            'new_pass' => 'La nueva contraseña ha de tener al menos una letra minuscula, una mayuscula, un numero y 8-100 caracteres',

            'rep_pass' => 'Las contraseñas son diferentes',
            'valid_pass' => 'Esa contraseña no es posible en camagru',

            'terms' => 'Debes de aceptar los terminos y condiciones',

            'empty' =>
            [
                'usermail' => 'Nombre de usuario o correo electronico vacio',
                'user' => 'Nombre de usuario vacio',
                'email' => 'Correo electronico vacio',
                'pass' => 'Contraseña vacia',
                'rep_pass' => 'Repeticion de contraseña vacia',
                'curr_pass' => 'Contraseña actual vacia',
                'new_pass' => 'Contraseña nueva vacia',
            ]
        ],

        'bbdd' =>
        [
            'usermail' => 'Usuario no encontrado en la bbdd',
            'pass' => 'Contraseña incorrecta',
            'curr_pass' => 'Contraseña actual incorrecta'
        ]
    ]    
];