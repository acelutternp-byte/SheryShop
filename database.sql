-- Optional setup for creating the database from phpMyAdmin by hand.
CREATE DATABASE IF NOT EXISTS sheryshop
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE sheryshop;

CREATE TABLE IF NOT EXISTS contact_messages (
    id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(120) NOT NULL,
    email VARCHAR(190) NOT NULL,
    subject VARCHAR(180) NOT NULL,
    message TEXT NOT NULL,
    submitted_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);