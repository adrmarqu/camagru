/* ---------------------------------------------------------- */
/*  notification_active: whether the user receives emails     */
/*  upon receiving a comment on their photos                  */
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
/*    account  → activate account after sign up               */
/*    email    → verify new email when updated                */
/*    password → reset password from forgot-password          */
/*    remember → automatic persistent login                   */
/*                                                            */
/*  new_email: holds pending unconfirmed new email            */
/*  (only populated when type = 'email')                      */
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
/*  filename: random 16-byte hash (32 hex chars) + extension. */
/*  Generated in PHP with:                                    */
/*    bin2hex(random_bytes(16)) . '.webp'                     */
/*                                                            */
/*  Full disk path:                                           */
/*    uploads/{folder}/media/{filename}                       */
/*                                                            */
/*  When account is deleted, the upload folder is deleted     */
/*  and foreign key CASCADE handles the database cleanup      */
/* ---------------------------------------------------------- */
CREATE TABLE photos
(
    id          INT UNSIGNED        AUTO_INCREMENT PRIMARY KEY,
    filename    VARCHAR(100)        NOT NULL,
    created_at  TIMESTAMP           NOT NULL DEFAULT CURRENT_TIMESTAMP,
    user_id     INT UNSIGNED        NOT NULL,
    
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    UNIQUE KEY unique_user_photo (user_id, filename)
);

/* Public gallery: ORDER BY created_at DESC */
CREATE INDEX idx_photos_created_at     ON photos(created_at);

/* Private gallery: WHERE user_id = ? ORDER BY created_at DESC */
CREATE INDEX idx_photos_user_created   ON photos(user_id, created_at);

/* ---------------------------------------------------------- */
/*  No dedicated id field: Composite PK (user_id, photo_id)   */
/*  guarantees a user can only like each photo once.          */
/*  Like added → row exists. Like removed → row deleted.      */
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
/*  comment: max 255 chars                                    */
/*  ON DELETE CASCADE: if photo or user is deleted,           */
/*  associated comments are deleted automatically             */
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

/* Photo comments: WHERE photo_id = ? ORDER BY created_at ASC */
CREATE INDEX idx_comments_photo_created ON comments(photo_id, created_at);


/* Clean expired tokens automatically */
SET GLOBAL event_scheduler = ON;

CREATE EVENT IF NOT EXISTS clean_expired_tokens
ON SCHEDULE EVERY 1 HOUR DO
DELETE FROM tokens WHERE expires_at < CURRENT_TIMESTAMP;