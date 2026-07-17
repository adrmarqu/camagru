<?php

class TokenModel extends BaseModel
{
    CREATE TABLE tokens
(
    id          INT UNSIGNED        AUTO_INCREMENT PRIMARY KEY,
    token       VARCHAR(255)        UNIQUE NOT NULL,
    type        ENUM('account', 'email', 'password', 'remember') NOT NULL DEFAULT 'account',
    new_email   VARCHAR(100),
    expires_at  TIMESTAMP           NOT NULL,
    user_id     INT UNSIGNED        NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

    public function generateTokenAccount(int $id): array
    {
        if (!$id)
            throw new AppException(500);

        /* 
        
        - Mirar si existe token
            - Si existe
                - Esta expirado
                    - Eliminar y volver a crear uno nuevo
                - No esta expirado
                    - No crea uno nuevo
            - No existe
                - Crear uno nuevo
         
            
        
        */

        $sql = "SELECT";
        $params = "";


        // Generar token
        $token = bin2hex(random_bytes(32));

        $sql = "INSERT INTO tokens (token, expires_at, user_id) VALUES (:token, NOW() + INTERVAL 5 MINUTE, :id)";
        $params =
        [
            'token' => $token,
            'id' => $id
            ];

        $this->query($sql, $params);

        return
        [
            'success' => true,
            'token' => $token
        ];
    }
}