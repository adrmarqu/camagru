# Auth

## Login y Signin

### Acceso 

Puedes acceder a la página de login y signin siempre que estes desconectado, el link está en el header. También puedes acceder a la página de signin desde la página de login.

### Estructura Login
- Usuario o correo
- Contraseña
- Recuerdame
- He olvidado mi contraseña
- Crear cuenta
- Cancelar
- Enviar

### Estructura Singin
- Usuario
- Correo
- Contraseña
- Repetir contraseña
- Terminos y servicios
- Cancelar
- Enviar

### Funcionamiento

Cuando le das a enviar, checkForm.js envia los datos a la api de validateFormJs.php, que enviara los datos al servidor para que los compruebe, devolvera error en caso de que se cumpla alguna de estas caracterisiticas:

- Campo vacio
- Usuario
    - Menos de 3 caracteres
    - Más de 15 caracteres
    - En caso de que empieze por numero
    - En caso de que contenga algo diferente a una letra, un numero o un guion medio o bajo.
- Correo
    - Longitud superior a 255 caracteres
    - No pasar el filtro de php filter_var($email, FILTER_VALIDATE_EMAIL)
- Contraseña
    - Menos de 8 caracteres
    - Mas de 72 caracteres
    - No tener letra mayuscula
    - No tener letra minuscula
    - No tener numero
    - No tener caracter especial (@$!%*?&)
    - En caso de signin, la contraseña repetida sea diferente
- Terminos
    - No aceptar terminos y servicios

En caso de fallar, saldra un cuadro de texto con los errores.
Si superas el formulario, iras al backend y ahi volveras a comprobar los datos de la misma forma, y luego iras a models para comprobarlos con la base de datos, dara error en estos casos:

- Login
    - Usuario o correo no existe
    - Contraseña incorrecta
    - Cuenta no activada: Redirige a verificacion y envia un nuevo link
    - Fallo al conectar a la bd

- Signin
    - Usuario ya existe
    - Correo ya existe
    - Fallo al conectar a la bd

En caso de error, la pagina se recargara con el cuadro de texto mostrandote los errores.
En caso de exito:

- Login
    - Remeber user activado: crear una cookie con token (HTTPOnly)
    - Obtener 'user_id' y ganar acceso al resto de la página

- Signin
    - Se creare un hash_user
    - Se creara tu cuenta con estado desacticado
    - Se te enviar un correo con un link
    - Se te redirigira a verificación

Si la cookie no exsite el remember estara desactivado.
Si la cookie existe el remember estara activado en el login. Si haces login con el remember desactivado, la cookie se eliminara, si no se renovara.


## Verificacion

Después de hacer signin, o de haber actualizado tu correo seras redirigido aqui. Este apartado tiene un texto con instrucciones para activar tu cuenta o tu nuevo email. Además habrá un boton que podras pulsar para poder volver a enviar un nuevo link a tu correo. Solo se generara un nuevo token cada 60 segundos.


## Actualizar

Para actualizar los datos de tu cuenta solo podras hacerlo desde tu perfil.

### Acciones

Cuando actualizes tus datos de la cuenta, sera igual al login y al signin, primero se pasa por checkForm.js, luego a validateFormJs.php y la misma logica.

- En caso de que algun campo este vacio o no cumpla las normas de login/signin dara error. Si la conexion con la db falla, tambien dara error.

### Actualizar usuario

#### Estructura

- Nuevo usuario
- Contraseña actual
- Cancelar
- Enviar

En caso de que el usuario ya exista o de que la contraseña este mal, dará error.

### Actualizar correo

#### Estructura

- Nuevo correo
- Contraseña actual
- Cancelar
- Enviar

En caso de que el correo ya este en uso o de que la contraseña este mal, dará error.

Si lo acepta, se te redirigira a verificacion y enviara un correo con un link para comprobar que ese correo sea tuyo. Necesitaras hacer click en el link para cambiar el correo.

### Actualizar contraseña

#### Estructura

- Contraseña actual
- Nueva contraseña
- Repetir nueva contraseña
- Cancelar
- Enviar

En caso de que la contraseña actual sea incorrecta dara error.


### Actualizar contraseña olvidada

#### Contraseña olvidada

- Introduce tu correo
- Cancelar
- Enviar

Envia un correo con un link

#### Nueva contraseña

- Nueva contraseña
- Repetir nueva contraseña
- Cancelar
- Enviar

Al aceptar el link con el token, te redirigira aqui para introducir tu nueva contraseña. Una vez dado a enviar, si no hay errores redirigira a login.
