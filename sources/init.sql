/* TABLES */

CREATE TABLE users
(
    id              SERIAL PRIMARY KEY,
    username        VARCHAR(30) UNIQUE NOT NULL,
    email           VARCHAR(100) UNIQUE NOT NULL,
    password_hash   VARCHAR(255) NOT NULL,
    verified        BOOLEAN
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

CREATE INDEX idx_images_userid ON images(user_id);

CREATE INDEX idx_likes_userid ON likes(user_id);
CREATE INDEX idx_likes_imageid ON likes(image_id);

CREATE INDEX idx_com_userid ON comments(user_id);
CREATE INDEX idx_com_imageid ON comments(image_id);