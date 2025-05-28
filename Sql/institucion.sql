-- Eliminar base de datos si existe
DROP DATABASE IF EXISTS institucion;

-- Crear nueva base de datos con codificación UTF8
CREATE DATABASE institucion 
    CHARACTER SET utf8mb4 
    COLLATE utf8mb4_unicode_ci;

-- Usar la base de datos
USE institucion;

-- Tabla de usuarios (añadido campo de rol)
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    contrasena VARCHAR(255) NOT NULL,
    email VARCHAR(75) NOT NULL UNIQUE,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    rol ENUM('admin','profesor') DEFAULT 'profesor'
) ENGINE=InnoDB;

-- Usuario por defecto con rol ADMIN
INSERT INTO usuarios (username, contrasena, email, rol)
VALUES ('admin', 'admin123', 'admin@institucion.local', 'admin');

-- Tabla de Ejemplos (antes llamada tareas)
CREATE TABLE ejemplos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(50) NOT NULL,
    descripcion TEXT,
    imagen VARCHAR(255) NULL,  -- Ruta de la imagen del ejemplo
    completado BOOLEAN DEFAULT FALSE,
    usuario_id INT NOT NULL,
    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    actualizado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Tabla de proyectos (con campo imagen y estado)
CREATE TABLE proyectos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    descripcion TEXT,
    fecha_inicio DATE NOT NULL,
    fecha_fin DATE NOT NULL,
    usuario_id INT NOT NULL,
    imagen VARCHAR(255) NULL,
    estado ENUM('planificado','en_progreso','completado') DEFAULT 'planificado',
    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    actualizado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE
) ENGINE=InnoDB;