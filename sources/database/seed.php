<?php

if (getenv('APP_ENV') !== 'local')
    die("Forbidden");

require_once dirname(__DIR__) . '/app/model/Database.php';

$pdo = Database::getConnection();

$stmt = $pdo->prepare("
    INSERT INTO users (username, email, password_hash, is_verified)
    VALUES (:u, :e, :p, :v)
");

$users =
[
    [
        'u' => 'user1',
        'e' => 'user1@gmail.com',
        'p' => password_hash('UserUser1', PASSWORD_DEFAULT),
        'v' => true
    ],
    [
        'u' => 'user2',
        'e' => 'user2@gmail.com',
        'p' => password_hash('UserUser2', PASSWORD_DEFAULT),
        'v' => true
    ],
    [
        'u' => 'user3',
        'e' => 'user3@gmail.com',
        'p' => password_hash('UserUser3', PASSWORD_DEFAULT),
        'v' => true
    ]
];

$pdo->beginTransaction();

foreach ($users as $user) {
    $stmt->execute($user);
}

$pdo->commit();