# Errores de navegación

Estos errores redirigen a la página de errores

- 401: No autorizado (Tienes de inicar session para entrar en x)
- 403: Acceso denegado (Estas autenticado pero no tienes permisos -admin-)
- 404: Página no encontrada (La página no existe)
- 500: Error interno del servidor (Error interno)

# Errores de validación

- 400: Solicitud incorrecta

Ej: No tiene coma, o quizas no esta bien cerrado (no hay corchete)
{
    name: 'Hola'
    email: 'email@gmail.com'
}

- 405: Metodo no permitido (Hacer un delete en un form por ejemplo)
- 409: Conflicto (El usuario ya existe, o el email ya existe)
- 422: Datos no validos (el email esta mal escrito, el username tiene un caracter especial...)
