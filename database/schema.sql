-- Crear base de datos
CREATE DATABASE IF NOT EXISTS contact2;
USE contact2;

-- Tabla de usuarios
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    role ENUM('admin', 'user') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabla de logs de SMS
CREATE TABLE IF NOT EXISTS sms_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    recipient VARCHAR(20) NOT NULL,
    campaign VARCHAR(100) DEFAULT 'Individual',
    message TEXT NOT NULL,
    response TEXT,
    status VARCHAR(50),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabla de logs de correos
CREATE TABLE IF NOT EXISTS email_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    recipient VARCHAR(100) NOT NULL,
    subject VARCHAR(255) NOT NULL,
    status ENUM('sent', 'failed') NOT NULL,
    error TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabla de logs de audios
CREATE TABLE IF NOT EXISTS audio_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    recipient VARCHAR(20) NOT NULL,
    campaign VARCHAR(100) DEFAULT 'Individual',
    audio_file VARCHAR(255) NOT NULL,
    response TEXT,
    status VARCHAR(50),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Usuario administrador por defecto
-- Usuario: admin
-- Contraseña: admin123
INSERT INTO users (username, password, email, role) VALUES 
('admin', 'admin123', 'admin@contact-center.com', 'admin');
