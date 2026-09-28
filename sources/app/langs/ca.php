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
        'login' => 'Iniciar sessió',
        'signin' => 'Registrar usuari',
        'forgot' => 'Recuperar contrasenya',
        // User
        'profile' => 'Perfil',
        'favorites' => 'Favorits',
        'private-gallery' => 'La meva galeria',
        // Token
        'verify' => 'Verificació',
        'result' => 'Resultat',
        'reset-password' => 'Restablir contrasenya',
        'send-email' => 'Enviar correu'
    ],

    'es' => 'Espanyol',
    'ca' => 'Català',
    'en' => 'Anglès',

    'header' =>
    [
        'gallery' => 'Galeria',
        'editor' => 'Editor de fotos',
        'login' => 'Iniciar sessió',
        'signin' => 'Registrar-se',
        'profile' => 'Perfil',
        'favorites' => 'Els meus favorits',
        'private' => 'La meva galeria',
        'logout' => 'Tancar sessió',
        'languages' => 'Idiomes'
    ],

    'link' =>
    [
        'gallery' => 'Tornar a la galeria'
    ],

    'db' =>
    [
        'exists' =>
        [
            'user' => 'Aquest usuari ja està en ús',
            'email' => 'Aquest correu ja està en ús'
        ]
    ],

    'form' =>
    [
        'label' =>
        [
            'usermail' => 'Usuari o correu electrònic',
            'user' => 'Usuari',
            'email' => 'Correu electrònic',
            'pass' => 'Contrasenya',
            'conf' => 'Confirmar contrasenya',
        ],
        // Placeholder
        'ph' =>
        [
            'usermail' => 'Usuari o correu electrònic',
            'user' => 'Usuari',
            'email' => 'Correu electrònic',
            'pass' => 'Contrasenya',
            'conf' => 'Repetir contrasenya',
            'new' => 'Nova contrasenya',
            'confi' => 'Repetir nova contrasenya',
            'curr' => 'Contrasenya actual',
            'comment' => 'Escriure un comentari'
        ],
        // Errors
        'error' =>
        [
            'user' => 'L\'usuari ha de començar per una lletra i només pot contenir lletres, números i guions',
            'email' => 'El correu ha de ser vàlid',
            'pass' => 'La contrasenya ha de tenir 8-72 caràcters, una majúscula, una minúscula i un número',
            'conf' => 'Les contrasenyes no coincideixen'
        ],
        // Error void
        'void' => 'Aquest camp és obligatori'
    ],

    'login' =>
    [
        'title' => 'Iniciar sessió',
        'intro' => 'Benvingut de nou.',
        'remember' => 'Recorda\'m',
        'no_account' => 'No tens compte? ',
        'new' => 'Registra\'t',
        'forgot' => 'Has oblidat la teva contrasenya? ',
        'reset' => 'Recupera-la'
    ],

    'signin' =>
    [
        'title' => 'Registrar usuari',
        'intro' => 'Benvingut a Camagru',
        'accept' => 'Accepto els ',
        'terms' => 'Termes i condicions',
        'account' => 'Ja tens un compte? ',
        'log' => 'Inicia sessió',
        'no_terms' => 'Has d\'acceptar els termes i condicions'
    ],

    'forgot' =>
    [
        'title' => 'Has oblidat la contrasenya',
        'intro' => 'Introdueix el correu del teu compte',
        'message' => 'He recordat la meva contrasenya! ',
        'login' => 'Inicia sessió'    
    ],

    'send' =>
    [
        'title' => 'Enviar correu',
        'intro' => 'Pots tornar a enviar un correu',
        'message' => 'Ja no ho necessito! ',
        'home' => 'Anar a la galeria'
    ],

    'reset' =>
    [
        'title' => 'Restableix la contrasenya',
        'intro' => 'Introdueix la teva nova contrasenya',
        'message' => 'No vull canviar la contrasenya! ',
        'login' => 'Inicia sessió'
    ],

    'result' =>
    [
        'account' => 'Felicitats! <br><br> El teu compte ja ha estat activat. Ja pots iniciar sessió a Camagru',
        'email' => 'Felicitats! <br><br> El teu nou correu electrònic s\'ha actualitzat amb èxit.',
        'reset' => 'Felicitats! <br><br> La teva contrasenya s\'ha restablert amb èxit.'
    ],

    'profile' =>
    [
        'danger' =>
        [
            'title' => 'Zona de perill',
            'delete' => 'Eliminar el teu compte',
            'sure' => 'Segur que vols eliminar el compte?',
            'confirm' => 'Aquesta acció és irreversible, un cop eliminat el compte no es podrà tornar a recuperar. A més, s\'eliminaran totes les teves fotos, comentaris i m\'agrades de Camagru. Prem el botó cancel·lar per tornar enrere al perfil.',
            'pass' => 'Introdueix la teva contrasenya per confirmar'
        ],
        'noti' =>
        [
            'title' => 'Preferències',
            'label' => 'Rebre notificacions per correu electrònic'
        ],
        'stats' =>
        [
            'change_photo' => 'Canviar avatar',
            'title' => 'Estadístiques',
            'photos' => 'Fotos pujades',
            'likes' => 'M\'agrades rebuts',
            'comments' => 'Comentaris rebuts'
        ],
        'security' =>
        [
            'title' => 'Seguretat',
            'curr' => 'Contrasenya actual',
            'new' => 'Nova contrasenya',
            'conf' => 'Confirmar nova contrasenya'
        ],
        'info' =>
        [
            'title' => 'Informació',
            'user' => 'Nom d\'usuari'
        ]
    ],

    'editor' =>
    [
        'size' => 'Mida',
        'rotate' => 'Rotació',
        'sticker' =>
        [
            'cat' => 'Orelles de gat',
            'fire' => 'Foc',
            'flowers' => 'Flors',
            'fog' => 'Boira',
            'glasses' => 'Ulleres de sol',
            'hat' => 'Barret de copa',
            'moustache' => 'Bigoti'
        ]
    ],

    'gallery' =>
    [
        'empty' => 'Actualment no hi ha imatges al servidor.',
        'load' => 'No hi ha més imatges al servidor.',
        'error' => 'Error en carregar les imatges del servidor.',
        'no_comment' => 'Encara no hi ha comentaris. Sigues el primer!',
        'do' => 'per comentar o donar m\'agrada',
        'sure' => 'Segur que vols eliminar aquesta publicació? S\'eliminaran permanentment els seus m\'agrades i comentaris.'
    ],

    'btn' =>
    [
        'send' => 'Enviar',
        'cancel' => 'Cancel·lar',
        'delete' => 'Eliminar compte',
        'update' => 'Actualitzar',
        'edit' => 'Editar',

        'gallery' => 'Tornar a la Galeria',
        'login' => 'Iniciar sessió',
        'profile' => 'Tornar al teu perfil',

        'sticker' => 'Eliminar sticker',
        'download' => 'Descarregar',
        'thumbnail' => 'Eliminar',
        'capture' => 'Fer foto',

        'more' => 'Carregar més'
    ],

    'email' =>
    [
        'account' =>
        [
            'subject' => 'Et donem la benvinguda a Camagru! Activa el teu compte',
            'title' => 'Activació de compte',
            'link' => 'Activar el meu compte',
            'body' => 'Gràcies per registrar-te a Camagru. Per començar a utilitzar el teu compte i gaudir de totes les funcions, si us plau activa\'l prement el botó de sota. Tingues en compte que l\'enllaç caducarà en 30 minuts. Per sol·licitar un nou enllaç, torna a /send-email i envia un nou correu. També pots iniciar sessió amb el teu compte per rebre un nou correu.'
        ],

        'email' =>
        [
            'subject' => 'Confirma el teu nou correu',
            'title' => 'Confirmació de correu',
            'link' => 'Confirmar nou correu',
            'body' => 'Camagru ha rebut una sol·licitud per canviar la teva adreça de correu. Si has estat tu, fes clic al botó de sota per confirmar el canvi. Si no has sol·licitat aquest canvi, pots ignorar aquest missatge de manera segura. Tingues en compte que l\'enllaç caducarà en 10 minuts. Per tornar a enviar un nou enllaç, torna a la pàgina de /send-email, o torna a canviar el teu correu des del teu perfil.'
        ],

        'reset' =>
        [
            'subject' => 'Restableix la teva contrasenya',
            'title' => 'Recuperar contrasenya',
            'link' => 'Restablir contrasenya',
            'body' => 'No et preocupis, ens passa a tots. Fes clic al botó de sota per triar una nova contrasenya de manera segura. Tingues en compte que, per motius de seguretat, aquest enllaç caducarà en 5 minuts. Per generar un nou enllaç, simplement torna a la pàgina de /forgot-password i envia un altre correu.'
        ],

        'comment' =>
        [
            'subject' => 'Nou comentari a la teva foto',
            'title' => 'Nou comentari!',
            'body' => 'ha comentat a una de les teves fotos:',
            'link' => 'Veure foto'
        ],

        'footer' => "Aquest és un correu automàtic, si us plau no responguis a aquest missatge. Si tens problemes o no has sol·licitat aquest correu, posa't en contacte amb suport. © $year Camagru. Tots els drets reservats."
    ],

    '200' =>
    [
        'user' => 'Nom d\'usuari actualitzat amb èxit.',
        'email' => 'S\'ha enviat un correu electrònic per confirmar el nou correu.',
        'usermail' => 'Usuari actualitzat amb èxit. Correu de confirmació enviat al teu nou correu.',
        'pass' => 'La contrasenya s\'ha actualitzat amb èxit.',
        'noti' => 'Preferències actualitzades amb èxit.',
        'avatar' => 'Avatar actualitzat amb èxit.',
        'image_uploaded' => 'Foto pujada amb èxit.',
        'image_deleted' => 'Foto eliminada amb èxit.'
    ],
    // Bad request
    '400' =>
    [
        'title' => 'Petició incorrecta',
        'message' => 'La sol·licitud no s\'ha pogut processar o és invàlida.',
        'corrupt_url' => 'Camagru no pot llegir aquest URL (URL corrupte)',
        'not_image' => 'El fitxer no és una imatge vàlida.',
        'size_image' => 'La imatge supera la mida màxima permesa (màx 10 MB).',
        'data' => 'Falten dades de la imatge o stickers.'
    ],
    // Not authenticated
    '401' =>
    [
        'title' => 'No autoritzat',
        'message' => 'Has d\'iniciar sessió per accedir a aquest contingut.',
        'login' => 'Usuari, correu o contrasenya incorrectes.'
    ],
    // Authenticated, but you need admin
    '403' =>
    [
        'title' => 'Accés denegat',
        'message' => 'No tens permisos per accedir a aquesta pàgina.',
        'no_token' => 'Necessites un token per accedir a aquesta pàgina.'
    ],
    // Not found
    '404' =>
    [
        'title' => 'Pàgina no trobada',
        'message' => 'La pàgina que busques no existeix o s\'ha mogut',
        'action' => 'Aquest tipus de formulari no existeix',
        'no_token' => 'El token no existeix o ha caducat',
        'no_file' => 'Aquest fitxer no existeix en aquesta ruta',
        'get' => 'La consulta introduïda no existeix a Camagru'
    ],
    // When you do POST, and POST doesn't exist in that route
    '405' =>
    [
        'title' => 'Mètode no permès',
        'message' => 'L\'acció sol·licitada no està permesa per a aquesta pàgina.'
    ],
    // Conflict
    '409' =>
    [
        'title' => 'Conflicte',
        'message' => 'Hi ha hagut un conflicte en processar la sol·licitud (ex. el recurs ja existeix a la base de dades).',
        'pass' => 'La nova contrasenya ha de ser diferent de l\'actual'
    ],
    // Expired
    '410' =>
    [
        'title' => 'Ja no disponible',
        'message' => 'El recurs sol·licitat ja no està disponible i s\'ha eliminat permanentment (ex. l\'enllaç ha caducat).'
    ],
    // Unprocessable Entity
    '422' =>
    [
        'title' => 'Dades no vàlides',
        'message' => 'Les dades enviades no són vàlides o estan incompletes.',
        'pass' => 'Contrasenya incorrecta'
    ],
    // Internal error
    '500' =>
    [
        'title' => 'Error intern del servidor',
        'message' => 'Ha ocorregut un error inesperat. Torna-ho a provar més tard.',
        'not_found' => 'El fitxer de la pàgina no existeix.',
        'no_class' => 'Classe inexistent: ',
        'no_method' => 'Mètode de classe inexistent: ',
        'no_access' => 'Accés inexistent: ',
        'token' => 'No s\'ha pogut crear un token. Si us plau, torna-ho a provar més tard.',
        'send' => 'Hi ha hagut un problema en enviar el correu.',
        'db' => 'Error a la base de dades.',
        'delete_token' => 'No s\'ha pogut eliminar el token.',
        'activate' => 'No s\'ha pogut activar el compte.',
        'change_email' => 'No s\'ha pogut actualitzar el correu.',
        'type' => 'Aquest tipus de token no existeix.',
        'update_pass' => 'No s\'ha pogut actualitzar la contrasenya',
        'delete' => 'No s\'ha pogut eliminar el compte.',
        'no_folder' => 'No existeix un directori per desar les imatges.',
        'folder' => 'Error en crear un directori.',
        'format' => 'Format d\'imatge no suportat.',
        'save_image' => 'Error en desar la imatge.'
    ],

    'footer' =>
    [
        'rights' => 'Tots els drets reservats.',
        'developed' => 'Desenvolupat amb ❤️ per a',
        'web' => 'El meu lloc web'
    ]
];

return $lang;