# Auth

## Login y Signin

### Acceso 

Puedes acceder a la página de login siempre que estes desconectado, el link está en el header. Para acceder a la página de signin lo puedes hacer en la página de login.

### Estructura Login
- Usuario/Correo
- Contraseña
- Recuerdame
- Crear cuenta

### Estructura Singin
- Usuario
- Correo
- Contraseña
- Repetir contraseña
- Terminos y servicios

### Funcionamiento

Cuando le das a enviar, checkForm.js envia los datos a la api de validateFormJs.php, que enviara los datos al servidor para que los compruebe, devolvera error en caso de que se cumpla alguna de estas caracterisiticas:

- Campo vacio
- Usuario
    - Menos de 3 caracteres
    - Más de 15 caracteres
    - En caso de que empieze por numero
    - En caso de que contenga algo diferente a una letra, un numero o un guion medio o bajo.
- Correo
    - Longitud superior a 100 caracteres
    - No pasar el filtro de php 'filter_var($email, FILTER_VALIDATE_EMAIL)'
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
    - Cuenta no activada: Redirige a verificar cuenta y envia un nuevo codigo
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
    - Se creara tu cuenta con estado desacticado
    - Se te enviar un correo con un codigo
    - Se te redirigira a verificar cuenta


## Verificar cuenta nueva

### Estructura

- Codigo: Donde introducir el codigo
- Generar nuevo codigo: Puedes generar un nuevo codigo cada 60 segundos
- Enviar

Después de hacer el signin, se generara un token de tipo cuenta y recibirás un correo con un codigo numerico de 6 digitos que deberás introducir en la página de verificar cuenta para activar tu cuenta.

### Caracteristicas

- Dura 10 minutos
- Tienes 3 intentos

En caso de cumplir una de estas caracteristicas podras generar un nuevo codigo


## Verificar correo

Cuando te cambies el correo que tienes por otro, se generar un token de tipo correo, se enviara un link a tu nuevo correo y cuando hagas click al link tu correo se cambiara por el nuevo.

### Caracteristicas

- Dura 10 minutos

## Actualizar

Para actualizar los datos de tu cuenta solo podras hacerlo desde tu perfil.

### Acciones

Cuando actualizes tus datos de la cuenta, sera igual al login y al signin, primero se pasa por checkForm.js, luego a validateFormJs.php y la misma logica.

- En caso de que algun campo este vacio o no cumpla las normas de login/signin dara error. Si la conexion con la db falla, tambien dara error.

### Actualizar usuario

#### Estructura

- Nuevo usuario
- Contraseña actual
- Enviar

En caso de que el usuario ya exista o de que la contraseña este mal, dará error.

### Actualizar correo

#### Estructura

- Nuevo correo
- Contraseña actual
- Enviar

En caso de que el correo ya este en uso o de que la contraseña este mal, dará error.

Si lo acepta, enviara un correo con un link para comprobar que ese correo sea tuyo. Necesitaras hacer click en el link para cambiar el correo.

### Actualizar contraseña

#### Estructura

- Contraseña actual
- Nueva contraseña
- Repetir nueva contraseña
- Enviar

En caso de que la contraseña actual sea incorrecta dara error.
