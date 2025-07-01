<?php
require_once '../app/config/config.php';

try {
    // Crear la conexión sin seleccionar base de datos
    $pdo = new PDO(
        "mysql:host=" . DB_HOST,
        DB_USER,
        DB_PASS,
        array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)
    );
    
    // Crear la base de datos si no existe
    $pdo->exec("CREATE DATABASE IF NOT EXISTS " . DB_NAME);
    $pdo->exec("USE " . DB_NAME);
    
    echo "Base de datos creada/seleccionada correctamente<br>";
    
    // Leer y ejecutar el archivo schema.sql
    $schema = file_get_contents('../database/schema.sql');
    $pdo->exec($schema);
    
    echo "Esquema de base de datos cargado correctamente<br>";
    
    // Verificar usuario admin
    $stmt = $pdo->query("SELECT * FROM users WHERE username = 'admin'");
    $user = $stmt->fetch(PDO::FETCH_OBJ);
    
    if($user) {
        echo "Usuario admin ya existe<br>";
        
        // Verificar si la contraseña es correcta
        if(password_verify('admin123', $user->password)) {
            echo "La contraseña del usuario admin es correcta<br>";
        } else {
            // Actualizar la contraseña
            $hash = password_hash('admin123', PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("UPDATE users SET password = ? WHERE username = 'admin'");
            $stmt->execute([$hash]);
            echo "Contraseña del usuario admin actualizada<br>";
        }
    } else {
        // Crear usuario admin
        $hash = password_hash('admin123', PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO users (username, password, email, role) VALUES (?, ?, ?, ?)");
        $stmt->execute(['admin', $hash, 'admin@contact-center.com', 'admin']);
        echo "Usuario admin creado correctamente<br>";
    }
    
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage() . "<br>";
}
