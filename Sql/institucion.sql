CREATE DATABASE institucion;
USE institucion;

CREATE TABLE usuarios (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) UNIQUE,
    password VARCHAR(255),
    rol ENUM('admin', 'maestro', 'alumno'),
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE archivos (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(255),
    ruta VARCHAR(255),
    tipo ENUM('ejercicio', 'ejemplo'),
    usuario_id INT,
    fecha_subida TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
) ENGINE=InnoDB;