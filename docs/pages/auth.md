# Auth

Páginas solo accesibles cuando no estes logueado

# Form errores

Primero se comprobaran los errores (formato de los inputs) con un fetch. En caso de haber errores, el formulario no se enviara y se mostraran los errores en la página del formulario. Si no hay errores, los datos se enviaran al servidor y se volveran a comprobar, tanto el formato de los inputs, como con la base de datos.

- Si un campo del formulario tiene algun error, este se pondra debajo del input correspondiente.
- Si hay un error http (400, 405, 409, 422, 500), el error se mostrara encima del formulario.

# Login

Elementos:

- Usermail: Usuario o email existente en la bbdd
- Password: Contraseña correspondiente
- Remember_me: Recuerdame (Inicia session automaticamente la proxima vez que entres)
- Enviar: Envia los datos y luego redirige a la gallery
- Enlace a el signin
- Enlace al forgot

# Signin

Elementos:

- User: Usuario que no este registrado en la bbdd
- Email: Correo que no este registrado en la bbdd
- Password: Tu contraseña
- Confirm: Tu contraseña repetida
- Terms: Terminos y condiciones
- Enviar: Envia los datos a la bbdd y luego redirige al login

# Forgot-password

Elementos:

- Usermail: Usuario o email de tu cuenta
- Enviar correo: Boton para enviar un correo con un enlace con token que lleva a reset-password