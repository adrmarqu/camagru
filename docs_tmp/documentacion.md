# Documentación — Camagru

## Estructura general

```
URL:        /{lang}/{página}
Langs:      en | es | ca
Ejemplo:    /es/gallery
Redirect:   / → /en/gallery (por defecto)
```

Controladores → `sources/app/Controllers/`  
Vistas → `sources/app/Views/templates/pages/`  
Rutas → `sources/app/Resources/Config/routes.php`

---

## Acceso a páginas

| Página | Acceso |
|---|---|
| gallery | Público |
| photo-editor | 🔒 Login requerido |
| login | Solo invitados |
| signin | Solo invitados |
| forgot-password | Solo invitados |
| verify | Público (llega por email) |
| reset-password | Público (llega por email) |
| profile | 🔒 Login requerido |
| private-gallery | 🔒 Login requerido |
| favorites | 🔒 Login requerido |

---

## 1. Gallery `/gallery`

**Controlador:** `GalleryController::gallery()`  
**Acceso:** Público

### ¿Qué hace?
- Muestra todas las fotos de todos los usuarios ordenadas por `created_at DESC`
- Paginación: carga las primeras N fotos (ej. 5)
- Botón "Load more" carga más via AJAX sin recargar (bonus)
- En cada foto se muestra: imagen, autor, nº likes, comentarios
- Solo usuarios logueados pueden dar like y comentar

### Queries necesarias
```sql
-- Cargar fotos (con paginación por offset)
SELECT p.id, p.filename, p.user_id, p.created_at, u.username
FROM photos p
JOIN users u ON p.user_id = u.id
ORDER BY p.created_at DESC
LIMIT 5 OFFSET ?;

-- Contar likes de una foto
SELECT COUNT(*) FROM likes WHERE photo_id = ?;

-- Saber si el usuario actual ha dado like
SELECT 1 FROM likes WHERE user_id = ? AND photo_id = ?;

-- Cargar comentarios de una foto
SELECT c.comment, c.created_at, u.username
FROM comments c
JOIN users u ON c.user_id = u.id
WHERE c.photo_id = ?
ORDER BY c.created_at ASC;
```

### Acciones POST (AJAX — bonus)
- `POST /gallery` → dar/quitar like → devuelve nuevo nº de likes
- `POST /gallery` → añadir comentario → devuelve el comentario renderizado
  - Si `notification_active = TRUE` del autor → enviar email de notificación

### Validaciones
- Like: usuario logueado, foto existe
- Comentario: usuario logueado, foto existe, texto no vacío, max 255 chars, sanitizar XSS

---

## 2. Photo Editor `/photo-editor`

**Controlador:** `EditorController::editor()`  
**Acceso:** 🔒 Login requerido

### ¿Qué hace?
- Muestra la interfaz del editor con webcam + stickers
- El usuario puede: añadir stickers (max 10), moverlos, rotarlos, escalarlos
- Al hacer la foto: preview de la imagen resultante
- Opciones tras la foto: subir, descargar, o descartar (volver a hacer otra)
- El procesado de la imagen (fusión sticker + foto) se hace **en el servidor** con GD

### Flujo de subida
```
1. Usuario hace la foto en el canvas (JS)
2. Canvas → base64 → POST al servidor
3. PHP decodifica base64, fusiona con stickers via GD
4. Guarda en uploads/{user_id}/{filename}  (filename = bin2hex(random_bytes(16)) . '.jpg')
5. INSERT en photos (filename, user_id)
6. Respuesta: URL de la imagen guardada
```

### Queries necesarias
```sql
-- Insertar foto
INSERT INTO photos (filename, user_id) VALUES (?, ?);
```

### Validaciones
- Usuario logueado
- Imagen válida (tipo, tamaño)
- Máx 10 stickers
- Sanitizar nombre de archivo generado (usar solo el hash generado, nunca input del usuario)

---

## 3. Login `/login`

**Controlador:** `AuthController::login()`  
**Acceso:** Solo invitados (si hay sesión → redirigir a gallery)

### ¿Qué hace?
- Formulario: username/email + password + checkbox "Recuérdame"
- Si correcto: crear sesión, redirigir a gallery
- Si falla: mostrar error genérico (no decir si falla usuario o contraseña)

### Queries necesarias
```sql
-- Buscar usuario por username o email
SELECT id, username, password_hash, is_active
FROM users
WHERE username = ? OR email = ?;
```

### Validaciones
- Campos no vacíos
- `password_verify()` contra `password_hash`
- `is_active = TRUE` (cuenta verificada)
- Sanitizar inputs antes de la query

---

## 4. Signin `/signin`

**Controlador:** `AuthController::signin()`  
**Acceso:** Solo invitados

### ¿Qué hace?
- Formulario: username + email + password + confirmar password
- Si correcto: INSERT usuario + generar token + enviar email de verificación
- Redirigir a login con mensaje "revisa tu email"

### Queries necesarias
```sql
-- Comprobar que username y email no existen
SELECT id FROM users WHERE username = ? OR email = ?;

-- Insertar usuario
INSERT INTO users (username, email, password_hash) VALUES (?, ?, ?);

-- Insertar token de activación
INSERT INTO tokens (token, type, expires_at, user_id)
VALUES (?, 'account', DATE_ADD(NOW(), INTERVAL 24 HOUR), ?);
```

### Validaciones
- Username: 3-50 chars, solo alfanumérico + guion bajo
- Email: formato válido, `filter_var()`
- Password: mín 8 chars, mayúscula, minúscula, número (requisito del subject)
- Confirmar password: igual que password
- Username y email únicos (query antes del INSERT)
- `password_hash()` con `PASSWORD_BCRYPT`

---

## 5. Forgot Password `/forgot-password`

**Controlador:** `AuthController::forgot()`  
**Acceso:** Solo invitados

### ¿Qué hace?
- Formulario: email
- Si el email existe: genera token de tipo `password` y envía email con el link
- Si no existe: misma respuesta (no revelar si el email existe)
- Link del email: `APP_URL/reset-password?token=xxxx`

### Queries necesarias
```sql
-- Buscar usuario por email
SELECT id FROM users WHERE email = ? AND is_active = TRUE;

-- Borrar tokens de password anteriores del usuario (evitar duplicados)
DELETE FROM tokens WHERE user_id = ? AND type = 'password';

-- Insertar nuevo token
INSERT INTO tokens (token, type, expires_at, user_id)
VALUES (?, 'password', DATE_ADD(NOW(), INTERVAL 1 HOUR), ?);
```

### Validaciones
- Email formato válido
- Token expira en 1 hora

---

## 6. Verify `/verify`

**Controlador:** `TokenController::verify()`  
**Acceso:** Público (llega por link en el email)  
**Params:** `?token=xxxx`

### ¿Qué hace?
- Recibe el token por GET
- Si válido y no expirado:
  - Si `type = 'account'` → activa la cuenta (`is_active = TRUE`) → redirigir a login
  - Si `type = 'email'` → actualiza el email con `new_email` → redirigir a profile
- Si inválido o expirado: mostrar error

### Queries necesarias
```sql
-- Buscar token
SELECT t.user_id, t.type, t.new_email, t.expires_at
FROM tokens t
WHERE t.token = ? AND t.expires_at > NOW();

-- Activar cuenta (type = account)
UPDATE users SET is_active = TRUE WHERE id = ?;

-- Actualizar email (type = email)
UPDATE users SET email = ? WHERE id = ?;

-- Borrar token usado
DELETE FROM tokens WHERE token = ?;
```

### Validaciones
- Token existe y no ha expirado
- Borrar el token tras usarlo (un solo uso)

---

## 7. Reset Password `/reset-password`

**Controlador:** `TokenController::reset()`  
**Acceso:** Público (llega por link en el email)  
**Params:** `?token=xxxx`

### ¿Qué hace?
- GET: valida el token y muestra formulario (nueva password + confirmar)
- POST: actualiza la password si el token sigue válido
- Redirigir a login tras el cambio

### Queries necesarias
```sql
-- Validar token
SELECT user_id, expires_at FROM tokens
WHERE token = ? AND type = 'password' AND expires_at > NOW();

-- Actualizar password
UPDATE users SET password_hash = ? WHERE id = ?;

-- Borrar token usado
DELETE FROM tokens WHERE token = ?;
```

### Validaciones
- Token válido y no expirado
- Password: mismas reglas que en signin
- Confirmar password coincide
- Borrar token tras usarlo

---

## 8. Profile `/profile`

**Controlador:** `UserController::profile()`  
**Acceso:** 🔒 Login requerido

### ¿Qué hace?
- Muestra los datos actuales del usuario (username, email)
- Permite editar: username, email, password
- Toggle de notificaciones por email
- Botón de eliminar cuenta (con confirmación)
- Cambio de email → genera token `email` y envía verificación antes de aplicar

### Queries necesarias
```sql
-- Cargar datos del usuario
SELECT username, email, notification_active FROM users WHERE id = ?;

-- Actualizar username
UPDATE users SET username = ? WHERE id = ?;

-- Iniciar cambio de email (guarda en token, no en users todavía)
INSERT INTO tokens (token, type, new_email, expires_at, user_id)
VALUES (?, 'email', ?, DATE_ADD(NOW(), INTERVAL 24 HOUR), ?);

-- Actualizar password
UPDATE users SET password_hash = ? WHERE id = ?;

-- Toggle notificaciones
UPDATE users SET notification_active = ? WHERE id = ?;

-- Eliminar cuenta (CASCADE borra tokens, photos, likes, comments)
DELETE FROM users WHERE id = ?;
```

### Validaciones
- Username: mismas reglas que signin, comprobar que no existe ya
- Email: comprobar que no existe ya, enviar verificación antes de aplicar
- Password: pedir password actual para confirmar cambios importantes
- Eliminar cuenta: pedir confirmación (password actual o checkbox)
- Al eliminar: borrar carpeta `uploads/{user_id}/` del filesystem

---

## 9. Private Gallery `/private-gallery`

**Controlador:** `UserController::privateGallery()`  
**Acceso:** 🔒 Login requerido

### ¿Qué hace?
- Muestra solo las fotos subidas por el usuario logueado
- Ordenadas por `created_at DESC`
- Permite descargar cada foto
- Permite borrar cada foto (solo las propias)

### Queries necesarias
```sql
-- Cargar fotos del usuario
SELECT id, filename, created_at
FROM photos
WHERE user_id = ?
ORDER BY created_at DESC;

-- Borrar una foto (AND user_id garantiza que solo borras las tuyas)
DELETE FROM photos WHERE id = ? AND user_id = ?;
```

### Acciones POST
- Borrar foto → DELETE en BD + borrar archivo del filesystem
  - `unlink("uploads/{user_id}/{filename}")`

### Validaciones
- La foto pertenece al usuario logueado (siempre `AND user_id = ?` en el DELETE)

---

## 10. Favorites `/favorites`

**Controlador:** `UserController::favorites()`  
**Acceso:** 🔒 Login requerido

### ¿Qué hace?
- Muestra todas las fotos a las que el usuario logueado ha dado like
- Ordenadas por `created_at DESC` de la foto
- Misma visualización que la galería pública (foto, autor, likes, comentarios)

### Queries necesarias
```sql
-- Cargar fotos que le gustan al usuario
SELECT p.id, p.filename, p.created_at, u.username,
       COUNT(l2.user_id) AS total_likes
FROM likes l
JOIN photos p ON l.photo_id = p.id
JOIN users u ON p.user_id = u.id
LEFT JOIN likes l2 ON l2.photo_id = p.id
WHERE l.user_id = ?
GROUP BY p.id
ORDER BY p.created_at DESC;
```

---

## Notas generales

### Seguridad (obligatorio en todo)
- Usar **PDO con prepared statements** en todas las queries (nunca concatenar variables)
- Sanitizar outputs con `htmlspecialchars()` para prevenir XSS
- Verificar sesión al inicio de cada página protegida
- Regenerar `session_id()` tras el login

### Filesystem de fotos
```
uploads/
  {user_id}/
    {bin2hex(random_bytes(16))}.jpg
```
- Al borrar foto: `unlink("uploads/{user_id}/{filename}")`
- Al borrar cuenta: `deleteDirectory("uploads/{user_id}/")`

### Tokens
- Siempre expiración máxima: 24h para account/email, 1h para password
- Un solo uso: borrar el token tras procesarlo
- Limpiar tokens expirados periódicamente (o al hacer login)

### Email
- Usar PHPMailer o `mail()` nativo de PHP
- Links del formato: `{APP_URL}/{lang}/verify?token=xxxx`
- Notificación de comentario: solo si `notification_active = TRUE` del autor de la foto
