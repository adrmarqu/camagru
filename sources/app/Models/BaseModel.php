<?php

/* PDO metodos

# Conexion 
$pdo = new PDO($dsn, $user, $password);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

# Consultas
$stmt = query(string $sql): PDOStatement|false 
(SELECT * FROM users)
$stmt = prepare(string $sql): PDOStatement|false
(SELECT * FROM users WHERE username = :name)
execute(array $params = null): bool ['name' => "Juan", ...]
fetch(): array|false
fetchAll(): array
fetchColumn(): mixed
rowCount(): int
lastInsertId(): string

# Grupos
beginTransaction(): bool -> Inicia
(Realizar consultas en la bbdd)
commit(): bool -> Sube los cambios realizados en la bbdd
rollBack(): bool -> Deshace los cambios de beginTransaction() si no se ha hecho commit()

*/

abstract class BaseModel
{
    protected PDO $pdo;

    public function __construct()
    {
        $this->pdo = Database::getConnection();
    }

    /* INSERT, UPDATE, DELETE */
    protected function query(string $sql, array $params = []): int
    {
        $stmt = $this->execute($sql, $params);
        return $stmt->rowCount();
    }

    private function execute(string $sql, array $params = []): PDOStatement
    {
        $stmt = $this->pdo->prepare($sql);

        foreach ($params as $key => $value)
        {
            $type = match (gettype($value))
            {
                'integer' => PDO::PARAM_INT,
                'boolean' => PDO::PARAM_BOOL,
                'NULL'    => PDO::PARAM_NULL,
                default   => PDO::PARAM_STR,
            };
            $param = is_int($key) ? $key + 1 : (str_starts_with((string)$key, ':') ? $key : ":$key");
            $stmt->bindValue($param, $value, $type);
        }
        $stmt->execute();
        return $stmt;
    }

    /* SELECT one result */
    protected function select(string $sql, array $params = []): array|false
    {
        return $this->execute($sql, $params)->fetch();
    }

    /* SELECT multiple results */
    protected function selectAll(string $sql, array $params = []): array|false
    {
        $results = $this->execute($sql, $params)->fetchAll();
        return empty($results) ? false : $results;
    }

    /* Last Id uploaded */
    protected function lastId(): int
    {
        return (int) $this->pdo->lastInsertId();
    }
}