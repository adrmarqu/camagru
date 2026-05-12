# camagru
Aplicación web de editar y compartir fotos

# general

- 

# header

Contenido -> | Camagru         Gallery Editor Profile (settings, my gallery) |

# footer



# gallery

# editor

- Frontend:

    - Seleccionar sticker
    - Hacer/Subir foto
    - Subir foto al servidor
    - Cancelar/Descartar

- Bonus frontend:

    - Máximo de 10 stickers
    - Modificador de stickers
        - Escalar stickers
        - Rotar sticker
        - Resetear sticker
        - Eliminar sticker
    - Mover sticker de posición
    - Boton de descargar imagen

- Backend:

    - Merge: Recibe la imagen y el sticker, comprueba que sean imagenes, los fusiona y lo devuelve al frontend.
    - Upload: Sube la imagen al servidor y dube sus datos en la base de datos (nombre del archivo, formato, de quien es, un titulo, fecha de creacion)

- Bonus:

    - Merge: Recibe la imagen y hasta 10 stickers, comprueba que sean imagenes, mira las posiciones, rotacion y escala de los stickers y los fusiona en la imagen, luego lo devuelve al frontend.

# auth

FRONTEND

- Login:

    - Usuario/Correo (text)
    - Contraseña (pass)
    - Recuerdame (checkbox)
    - Crear cuenta (link)

- Signin:

    - Usuario (text)
    - Email (email)
    - Contraseña (pass)
    - Repetir contraseña (pass)
    - Terminos (checkbox) + abrir ventana con los terminos
    - Redirigir a verificación de cuenta en caso de pasar el form

- Update:

    - User:
        - Nuevo usuario (text)
        - Contraseña (pass)
    - Email:
        - Nuevo correo (text)
        - Contraseña (pass)
    - Pass:
        - Contraseña actual (pass)
        - Contraseña nueva (pass)
        - Repetir contraseña nueva (pass)

- Verificación:

    - Cuenta:
        - Codigo (number)
    - Email: El usuario no lo puede ver


- Cada campo sera comprobado en JavaScript con un fetch()

BACKEND

- Usuario:
    - Longitud: 3-15
    - Pattern: Solo letras, números y lo guiones '-' y '_'. El usuario ha de empezar por una letra.
    - Regex: '^[a-zA-Z][a-zA-Z0-9_-]{2,14}$'
- Correo:
    - Longitud: Maximo 100 caracteres.
    - Pattern: filter_var($email, FILTER_VALIDATE_EMAIL)
- Contraseña:
    - Longitud: 8-72
    - Pattern: Una letra mayuscula, una minuscula, un numero, un caracter especial
    - Regex: '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/'
    - Base de datos:
        - Encriptar: password_hash($password, PASSWORD_BCRYPT)
        - Comprobar: password_verify($password, $password_hash)
- Terminos: Para crear una cuenta tienes que activarlo
- Tokens:
    - Cuenta: Al crear un nuevo usuario, recibes un correo con un codigo y lo tienes que introducir.
    - Email: Para cambiar a un nuevo email se envia un link al correo, si haces click se cambia automaticamente.
    - Recordar usuario: Crear una cookie con el flag HttpOnly y con expiración
        - crear: setcookie("remember", $token, $duration, "/", "", false, true);
        - borrar: setcookie("remember", "", time() - 3600, "/", "", false, true);

- preg_match(Regex, $element)

- Cada campo sera comprobado de vuelta en el backend y luego enviado a la base de datos mientras los datos introducidos no existan ya en la base de datos

# profile


# base de datos


--------------------------------------------------------------



🚀 Camagru Technical Documentation
🛠️ Arquitectura y General
Patrón: MVC simplificado (Model-View-Controller).

Frontend: JavaScript Vanilla (AJAX/Fetch) para interacciones sin recarga.

Backend: PHP 7.4+ (Standard Library únicamente).

Seguridad: - XSS: Sanitización con htmlspecialchars().

SQL Injection: Uso estricto de PDO con Prepared Statements.

Passwords: Algoritmo BCRYPT vía password_hash.

CSRF: (Opcional pero recomendado) Tokens en formularios sensibles.

🖼️ Editor (Feature Central)
El editor permite la creación de fotomontajes cumpliendo la normativa del servidor.

Flujo: 1. Captura de Webcam (vía getUserMedia) o subida de archivo.
2. Selección de stickers con previsualización en tiempo real (Canvas).
3. Procesado: Se envían al servidor la imagen base (base64) y un JSON con:
- ID del sticker.
- Coordenadas (x, y).
- Transformaciones: Rotación (deg) y Escala (0.1 a 2.0).

Fusión (Server-side): Uso de la librería GD para superponer PNGs manteniendo transparencias.

👤 User Auth & Security
Registro: Confirmación obligatoria por email con código único.

Recuérdame: - Cookie con flags HttpOnly y SameSite=Strict.

Almacenamiento de Token Hash en DB (no el token plano).

Notificaciones: Sistema de alerta por email al recibir comentarios. Configurable desde el perfil (activado por defecto según Subject V.3).

📱 Galería y Bonus
Paginación: Sistema "Load More" mediante AJAX para evitar recargas completas.

Likes: Tabla relacional likes para gestionar el estado "toggle" (dar/quitar) instantáneamente vía fetch().

Comentarios: Publicación inmediata en el DOM tras validación en backend.

🗄️ Database Schema (ERD)
Users: Datos de cuenta, estado de verificación y preferencias de email.

Images: Ruta del archivo y relación con el autor.

Likes & Comments: Relaciones muchos-a-muchos con integridad referencial (ON DELETE CASCADE).

Tokens: Gestión centralizada de sesiones persistentes y validaciones temporales.