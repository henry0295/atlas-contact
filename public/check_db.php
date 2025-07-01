<?php
require_once '../app/config/config.php';

try {
    $pdo = new PDO(
        "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME,
        DB_USER,
        DB_PASS,
        array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)
    );
    
    // Verificar la conexión
    echo "Conexión exitosa a la base de datos<br>";
    
    // Verificar la tabla users
    $stmt = $pdo->query("SELECT * FROM users WHERE username = 'admin'");
    $user = $stmt->fetch(PDO::FETCH_OBJ);
    
    if($user) {
        echo "Usuario admin encontrado<br>";
        echo "Email: " . $user->email . "<br>";
        echo "Rol: " . $user->role . "<br>";
        
        // Verificar si la contraseña admin123 funciona
        if(password_verify('admin123', $user->password)) {
            echo "La contraseña admin123 es válida<br>";
        } else {
            echo "La contraseña admin123 NO es válida<br>";
            echo "Hash almacenado: " . $user->password . "<br>";
        }
    } else {
        echo "Usuario admin NO encontrado<br>";
    }
    
} catch(PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
}
