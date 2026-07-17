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
        $this->pdo = Database::getConn();
    }

    /* Query */
    protected function query(string $sql, array $params = []): PDOStatement
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    /* Select one result */
    protected function select(string $sql, array $params = []): array|false
    {
        return $this->query($sql, $params)->fetch();
    }

    /* Select all results */
    protected function selectAll(string $sql, array $params = []): array|false
    {
        $results = $this->query($sql, $params)->fetchAll();
        return empty($results) ? false : $results;
    }

    /* Last Id uploaded */
    protected function lastId(): int
    {
        return (int) $this->pdo->lastInsertId();
    }
}