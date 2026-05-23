<?php

/**
 * Database connection using PDO.
 * Reads credentials from environment variables (Docker Compose).
 */

function getDB(): PDO
{
    static $pdo = null;

    if ($pdo === null) {
        $host = getenv('DB_HOST') ?: 'db';
        $dbname = getenv('DB_NAME') ?: 'recipe_db';
        $user = getenv('DB_USER') ?: 'recipe_user';
        $pass = getenv('DB_PASS') ?: 'recipe_pass';

        $dsn = "mysql:host={$host};dbname={$dbname};charset=utf8mb4";

        $pdo = new PDO($dsn, $user, $pass, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);
    }

    return $pdo;
}
