-- 1. Eliminar la base de datos si existe y crearla
DROP DATABASE IF EXISTS institucion;

CREATE DATABASE institucion 
    CHARACTER SET utf8mb4 
    COLLATE utf8mb4_unicode_ci;

-- 2. Seleccionar la base de datos
USE institucion;

-- 3. Eliminar tablas si existen
DROP TABLE IF EXISTS files;
DROP TABLE IF EXISTS users;

-- 4. Crear tabla users
CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    role ENUM('admin', 'teacher', 'student') NOT NULL DEFAULT 'student',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- 5. Crear tabla files
CREATE TABLE files (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    path VARCHAR(255) NOT NULL,
    type ENUM('exercise', 'example') NOT NULL,
    user_id INT NOT NULL,
    uploaded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB;