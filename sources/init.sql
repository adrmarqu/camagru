/* TABLES */

CREATE TABLE users
(
    id              SERIAL PRIMARY KEY,
    username        VARCHAR(30) UNIQUE NOT NULL,
    email           VARCHAR(100) UNIQUE NOT NULL,
    password_hash   VARCHAR(255) NOT NULL,
    is_verified     BOOLEAN
);

CREATE TABLE tokens
(
    id              SERIAL PRIMARY KEY,
    token           VARCHAR(255) NOT NULL,
    type            VARCHAR(20) NOT NULL,
    new_value       VARCHAR(100),
    attempts        INTEGER NOT NULL DEFAULT 0,
    expires_at      TIMESTAMP NOT NULL,
    user_id         INTEGER NOT NULL REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE images
(
    id              SERIAL PRIMARY KEY,
    filename        VARCHAR(50) UNIQUE NOT NULL,
    created_at      TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    user_id         INTEGER NOT NULL REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE likes
(
    user_id         INTEGER NOT NULL REFERENCES users(id) ON DELETE CASCADE,
    image_id        INTEGER NOT NULL REFERENCES images(id) ON DELETE CASCADE,
    PRIMARY KEY (user_id, image_id)
);

CREATE TABLE comments
(
    id              SERIAL PRIMARY KEY,
    comment         VARCHAR(200) NOT NULL,
    created_at      TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    user_id         INTEGER NOT NULL REFERENCES users(id) ON DELETE CASCADE,
    image_id        INTEGER NOT NULL REFERENCES images(id) ON DELETE CASCADE
);

/* INDEXS */

CREATE INDEX idx_tokens_token ON tokens(token);

CREATE INDEX idx_users_username ON users(username);
CREATE INDEX idx_users_email ON users(email);

CREATE INDEX idx_images_userid ON images(user_id);

CREATE INDEX idx_likes_userid ON likes(user_id);
CREATE INDEX idx_likes_imageid ON likes(image_id);

CREATE INDEX idx_com_userid ON comments(user_id);
CREATE INDEX idx_com_imageid ON comments(image_id);


/* OTHERS */
    
ALTER TABLE tokens ADD CONSTRAINT unique_user_token_type UNIQUE (user_id, type);
