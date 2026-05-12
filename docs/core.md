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

