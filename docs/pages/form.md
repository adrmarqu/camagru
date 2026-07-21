# Form

Estaran formados por un titulo, un contenedor con los errores globales y el formulario.

- Cada componente del formulario será:

Label
Input
Span de error (Solo si es un campo obligatorio)

- En caso de ser un checkbox:

Input checkbox + Label
Span de error (Solo si es un campo obligatorio)

# Errores

## Globales

Mientras estes en un formulario, no te podra saltar ninguna pagina de error HTTP, ejemplo: si te sale un error 500, en vez de meter la pagina de error, en el formulario en el contenedor global, pondra el mennsaje de error. 

## Particulares

Estos son los errores individuales, por ejemplo si en el crear cuenta pones un username invalido, el mensaje de error que saldra se pondra en el span de username.

En caso de haber un error particular, el input de donde este el error, se le pondran los bordes rojos y solo se quitaran si modificas el contenido del input. En caso de que hay un input con un borde rojo, no podras enviar el formulario.