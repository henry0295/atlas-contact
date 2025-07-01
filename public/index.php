<?php
// Mostrar errores en desarrollo
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Definir función de autoload
spl_autoload_register(function ($class) {
    // Convertir namespace a ruta de archivo
    $prefix = 'App\\';
    $base_dir = __DIR__ . '/../app/';

    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }

    $relative_class = substr($class, $len);
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';
    
    if (file_exists($file)) {
        require $file;
    }
});

require_once '../app/config/config.php';

// Configuración de sesión
session_name(SESSION_NAME);
session_start();

// Crear instancia de la aplicación
$app = new App\Core\App;
