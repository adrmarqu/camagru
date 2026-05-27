# General

## Gestión de sesión y persistencia de usuarios

Antes de renderizar cualquier contenido, el sistema determina el estado de autenticación:

- Sessión activa: $_SESSION['user_id']
- Recordar usuario: !$_SESSION['user_id'] && $_COOKIE['remember_user']
- Estado invitado: !$_SESSION['user_id'] && !$_COOKIE['remember_user']

## Permmisos

En caso de no estar conectado solo podras estar en la página de gallery, además no podras dar like ni comentar las imagenes, aunque si podrás ver los comentarios publicados.

## Enrutamiento y URL amigables

Mediante reglas de reescritura en .htaccess se transforman las URL técnicas en estructuras semánticas:

http://camagru/{lang}/{page}

- lang: Selector de idioma (en, es, ca), por defecto 'en'.
- page: Identificador de la vista, por defecto 'gallery'.

## Arquitectura MVC

- Core: Estado (invitado, conectado), Limpiar url, decidir el controller
- Controller: Decide que hacer y se encarga de la lógica
- Model: Se encarga de conectar PHP con la base de datos
- View: Se encarga de generar el html para el frontend

## Screens

- gallery: Donde se muestran las fotos
- photo-editor: Donde modificas y subes las fotos
- login: Donde accedes a tu usuario
- signin: Donde creas un usuario
- update-user: Donde actualizas tu nombre de usuario
- update-email: Donde actualizas tu correo
- update-password: Donde actualizas tu password
- user/gallery: Donde estan tus fotos subidas
- user/favorites: Donde estan las fotos con tu like
- user/settings: Donde configuras el usuario
- send-email: Donde vuelves a enviar los correos

Si no estas conectado, solo puedes acceder a gallery, login, signin
Si no no se ha enviado un correo no puedes entrar a send-email