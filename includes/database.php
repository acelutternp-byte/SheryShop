<?php

// Connect to MySQL and create the shop database and table if missing.
function databaseConnection(): PDO
{
    $options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];
    $server = new PDO('mysql:host=127.0.0.1;charset=utf8mb4', 'root', '', $options);
    $server->exec('CREATE DATABASE IF NOT EXISTS sheryshop CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci');

    $database = new PDO('mysql:host=127.0.0.1;dbname=sheryshop;charset=utf8mb4', 'root', '', $options);
    $database->exec("CREATE TABLE IF NOT EXISTS contact_messages (
        id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(120) NOT NULL,
        email VARCHAR(190) NOT NULL,
        subject VARCHAR(180) NOT NULL,
        message TEXT NOT NULL,
        submitted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");

    return $database;
}