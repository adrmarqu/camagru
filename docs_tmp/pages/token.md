# Verify

Una vez que entres a está página podran passar 3 cosas:

- El token no existe en la url

Pondra la pagina de error 400: Bad request

- El token existe pero es incorrecto

Pondra la pagina de error 422: Unprocessable

- El token es válido

    - Activar cuenta: Activa la cuenta y redirige al /gallery
    - Forgot pass: Redirige a reset-password
    - New email: Cambia el correo antiguo por el nuevo y redirije a /profile


# Reset password

Elementos:

- Password: Nueva contraseña de tu cuenta
- Confirm: Repetir nueva contraseña
- Enviar: Envia los datos y redirige a /profile


# Send email

/${lang}/send-email?action=['account', 'email']

Conseguir el correo donde vas a enviar los correos: $_SESSION['send_email']

## Account (Correo para activar cuenta)

Error 403: Si estas logueado
Error 403: Si no tienes token (incluyendo uno expirado)

## Email (Correo para confirmar nuevo email)

Error 401: Si no estas logueado
Error 403: Si no tienes token (incluyendo uno expirado)

## Boton enviar

- Envio: /${lang}/verify?token=[...]

En caso de tener el token sin expirar, se pondra un temporizador inicial al boton de enviar correo

Al enviar se pone un temporizador (60s) que bloquea el boton
- Si el token no esta expirado, enviar nuevo correo con el token
- Si el token esta expirado, crear nuevo token y enviar correo con el nuevo token