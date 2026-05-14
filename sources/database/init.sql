/* TABLES */

CREATE TYPE user_role AS ENUM('admin', 'user');
CREATE TYPE token_type AS ENUM('account_creation', 'new_email', 'remember_user', 'new_pass');

CREATE TABLE users
(
    id              SERIAL PRIMARY KEY,
    username        VARCHAR(30) UNIQUE NOT NULL,
    email           VARCHAR(100) UNIQUE NOT NULL,
    user_hash       VARCHAR(255) NOT NULL UNIQUE,
    password_hash   VARCHAR(255) NOT NULL,
    is_active       BOOLEAN DEFAULT FALSE,
    role            user_role NOT NULL DEFAULT 'user',
    notification    BOOLEAN DEFAULT TRUE
);

CREATE TABLE tokens
(
    id              SERIAL PRIMARY KEY,
    token           VARCHAR(255) NOT NULL UNIQUE,
    type            token_type NOT NULL DEFAULT 'account',
    new_email       VARCHAR(100),
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

/* INSERTS */

INSERT INTO users 
(username, email, password_hash, is_active, role, notification)
VALUES 
('super', 'super@super.com', 'super', true, 'admin', false);