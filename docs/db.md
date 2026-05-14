# Database

La base de datos es de Postgress y la db se llama 'camagru'

## Tablas

### Users

La tabla users estara formada por:

- id: clave primaria
- username: unique
- email: unique
- user_hash: nombre ed la carpeta donde se guardaran las imagenes subidas del usuario
- password_hash: la contraseña encriptada
- is_active: booleano que indica si la cuenta esta activada o no
- role: [user', 'admin']
- notification: un booleano que indica si recibes notificaciones o no

### Images

- id: clave primaria
- filename: nombre del archivo con su extension
- created_at: Cuando fue creada
- user_id: id de a quien pertenece la imagen

### Likes

- user_id: id del usuario que ha dad like
- image_id: id de la imagen que ha recibido el like

### Comments

- id: clave primaria
- comment: texto del comentario
- created_at: cuando fue creado
- user_id: id del usuario que ha hecho el comentario
- image_id: id de la imagen que fue comentada

### Tokens

- id: clave primaria
- token: token
- type: tipo de token ['account_creation', 'new_email', 'remember_user', 'new_pass']
- new_email: en caso de ser del type new_email, guardar el nuevo email
- expires_at: cuando expira el token
- user_id: id del usuario al que le pertenece el token


## INSERTS

- Superusuario
    - username: super
    - correo: super@super.com
    - password: super

El superusuario puede borrar imagenes en la galeria.