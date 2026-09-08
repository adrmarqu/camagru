/* ---------------------------------------------------------- */
/*  notification_active: si el usuario recibe emails al       */
/*  recibir un comentario en sus fotos                        */
/* ---------------------------------------------------------- */
CREATE TABLE users
(
    id                  INT UNSIGNED        AUTO_INCREMENT PRIMARY KEY,
    username            VARCHAR(50)         UNIQUE NOT NULL,
    folder              VARCHAR(50)         UNIQUE,
    email               VARCHAR(255)        UNIQUE NOT NULL,
    password_hash       VARCHAR(255)        NOT NULL,
    is_active           BOOLEAN             DEFAULT FALSE,
    notification_active BOOLEAN             DEFAULT TRUE
);

/* ---------------------------------------------------------- */
/*  type:                                                     */
/*    account  → activar la cuenta tras el registro           */
/*    email    → verificar el nuevo email al cambiarlo        */
/*    password → resetear la password con forgot-password     */
/*    remember → conectarse automaticamente                   */
/*                                                            */
/*  new_email: guarda el nuevo email sin confirmar            */
/*  (solo se rellena cuando type = 'email')                   */
/* ---------------------------------------------------------- */
CREATE TABLE tokens
(
    id          INT UNSIGNED        AUTO_INCREMENT PRIMARY KEY,
    token       VARCHAR(255)        UNIQUE NOT NULL,
    type        ENUM('account', 'email', 'password', 'remember') NOT NULL DEFAULT 'account',
    new_email   VARCHAR(100),
    expires_at  TIMESTAMP           NOT NULL,
    user_id     INT UNSIGNED        NOT NULL,
    
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    UNIQUE KEY unique_user_type (user_id, type)
);

CREATE INDEX idx_tokens_expires_at ON tokens(expires_at);

/* ---------------------------------------------------------- */
/*  filename: hash random de 16 bytes (32 chars hex) +        */
/*  extension. Se genera en PHP con:                          */
/*    bin2hex(random_bytes(16)) . '.jpg'                      */
/*                                                             */
/*  La ruta completa en disco es:                             */
/*    uploads/{user_id}/{filename}                            */
/*                                                             */
/*  Al borrar la cuenta se elimina la carpeta uploads/{id}/   */
/*  y el CASCADE se encarga del resto en la BD                */
/* ---------------------------------------------------------- */
CREATE TABLE photos
(
    id          INT UNSIGNED        AUTO_INCREMENT PRIMARY KEY,
    filename    VARCHAR(100)        UNIQUE NOT NULL,
    created_at  TIMESTAMP           NOT NULL DEFAULT CURRENT_TIMESTAMP,
    user_id     INT UNSIGNED        NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

/* Galería pública: ORDER BY created_at DESC */
CREATE INDEX idx_photos_created_at     ON photos(created_at);

/* Galería privada: WHERE user_id = ? ORDER BY created_at DESC */
CREATE INDEX idx_photos_user_created   ON photos(user_id, created_at);

/* ---------------------------------------------------------- */
/*  Sin campo id propio: la PK es compuesta (user_id,         */
/*  photo_id), lo que garantiza que un usuario solo pueda     */
/*  dar like una vez a cada foto.                             */
/*  Si das like → apareces. Si lo quitas → desapareces.       */
/* ---------------------------------------------------------- */
CREATE TABLE likes
(
    user_id     INT UNSIGNED        NOT NULL,
    photo_id    INT UNSIGNED        NOT NULL,
    PRIMARY KEY (user_id, photo_id),
    FOREIGN KEY (user_id)  REFERENCES users(id)  ON DELETE CASCADE,
    FOREIGN KEY (photo_id) REFERENCES photos(id) ON DELETE CASCADE
);

/* ---------------------------------------------------------- */
/*  comment: máx 255 chars                                     */
/*  ON DELETE CASCADE: si se borra la foto o el usuario,      */
/*  sus comentarios desaparecen también                        */
/* ---------------------------------------------------------- */
CREATE TABLE comments
(
    id          INT UNSIGNED        AUTO_INCREMENT PRIMARY KEY,
    comment     VARCHAR(255)        NOT NULL,
    created_at  TIMESTAMP           NOT NULL DEFAULT CURRENT_TIMESTAMP,
    user_id     INT UNSIGNED        NOT NULL,
    photo_id    INT UNSIGNED        NOT NULL,
    FOREIGN KEY (user_id)  REFERENCES users(id)  ON DELETE CASCADE,
    FOREIGN KEY (photo_id) REFERENCES photos(id) ON DELETE CASCADE
);

/* Comentarios de una foto: WHERE photo_id = ? ORDER BY created_at ASC */
CREATE INDEX idx_comments_photo_created ON comments(photo_id, created_at);


/* Eliminar tokens automaticamente */
SET GLOBAL event_scheduler = ON;

CREATE EVENT IF NOT EXISTS clean_expired_tokens
ON SCHEDULE EVERY 1 HOUR DO
DELETE FROM tokens WHERE expires_at < CURRENT_TIMESTAMP;