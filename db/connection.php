<?php

$path = __DIR__ . '/data.sqlite';
if (!file_exists($path)) {
    if (!touch($path)) {
        throw new RuntimeException(
            'Failed creating database file!'
        );
    }
}

$dsn = 'sqlite:' . $path;

$pdo = new PDO($dsn);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Creating `users` table
$pdo->exec(
    'CREATE TABLE IF NOT EXISTS `users` (
        `id` INTEGER NOT NULL PRIMARY KEY,
        `name` TEXT NOT NULL,
        `email` TEXT NOT NULL UNIQUE,
        `password` TEXT NOT NULL
    )'
);

return $pdo;
