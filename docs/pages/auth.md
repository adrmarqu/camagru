# Auth

# Login

Elementos:

- Usermail: Usuario o email existente en la bbdd
- Password: Contraseña correspondiente
- Remember_me: Recuerdame (Inicia session automaticamente la proxima vez que entres)
- Enviar: Envia los datos del formulario
- Enlace al signin
- Enlace al forgot

Al enviar los datos de la cuenta, primero mirara si los datos estan bien, sino dara error. En caso de que no haya datos erroneos, buscara en la base de datos si el usuario existe, si no existe dara error, si existe comprobara la contraseña que sea la correcta, y luego mirara si la cuenta está activada. Si no está activada, enviara un email al usuario con un link para activar la cuenta. Si está activada, mirara si esta marcado el recuerdame, si esta activado creara un token para la cookie e iniciara sesión y redirigira a la galeria.

Si la creación de la cookie falla, esta se ignorara y el usuario iniciara sesión igualmente.

## Login por recuerdame

Al entrar a la pagina web, si no estas logeado, intentara iniciar sessión por la cookie en caso de tenerla.

Cada vez que inicies sesión por la cookie esta renovara su tiempo de vida.

# Signin

Elementos:

- User: Usuario que no este registrado en la bbdd
- Email: Correo que no este registrado en la bbdd
- Password: Tu contraseña
- Confirm: Tu contraseña repetida
- Terms: Terminos y condiciones
- Enviar: Envia los datos a la bbdd

Una vez enviados los datos, se verifica su formato, luego se comprueba que el username y el email no existan y los introduce a la base de datos. Luego envia un correo para la activación de la cuenta. En caso de que el envio del email falle, no se insertara nada en la base de datos y dara un error global.

# Forgot-password

Elementos:

- Usermail: Usuario o email de tu cuenta
- Enviar correo: Boton para enviar un correo con un enlace con token que lleva a reset-password