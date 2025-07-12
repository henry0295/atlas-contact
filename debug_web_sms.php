<?php
// Script de depuración web para SMS
require_once __DIR__ . '/app/config/config.php';
require_once __DIR__ . '/app/core/Database.php';
require_once __DIR__ . '/app/core/Model.php';
require_once __DIR__ . '/app/models/Sms.php';

session_start();

use App\Models\Sms;

// Simular usuario autenticado para la prueba
$_SESSION['user_id'] = 1;

echo "<h2>Diagnóstico SMS desde el entorno web</h2>";

try {
    echo "<h3>1. Inicializando modelo SMS...</h3>";
    $smsModel = new Sms();
    echo "<span style='color:green'>✓ Modelo SMS inicializado correctamente</span><br>";
    
    echo "<h3>2. Enviando SMS de prueba...</h3>";
    
    $to = "573005462640";
    $message = "Mensaje de prueba desde la aplicación web - " . date('Y-m-d H:i:s');
    $campaign = "TEST_WEB_" . date('YmdHis');
    
    echo "Destinatario: $to<br>";
    echo "Mensaje: $message<br>";
    echo "Campaña: $campaign<br><br>";
    
    $result = $smsModel->send($to, $message, $campaign);
    
    echo "<h3>3. Resultado del envío:</h3>";
    echo "<pre>" . json_encode($result, JSON_PRETTY_PRINT) . "</pre>";
    
    if (isset($result['status']) && $result['status'] === 'success') {
        echo "<div style='color:green; font-weight:bold; padding:10px; background:#d4edda; border:1px solid #c3e6cb; margin:10px 0;'>";
        echo "✓ SMS enviado correctamente desde la aplicación web";
        echo "</div>";
    } else {
        echo "<div style='color:red; font-weight:bold; padding:10px; background:#f8d7da; border:1px solid #f5c6cb; margin:10px 0;'>";
        echo "✗ Error al enviar SMS: " . ($result['message'] ?? 'Error desconocido');
        echo "</div>";
    }
    
} catch (Exception $e) {
    echo "<div style='color:red; font-weight:bold; padding:10px; background:#f8d7da; border:1px solid #f5c6cb; margin:10px 0;'>";
    echo "Error de excepción: " . $e->getMessage();
    echo "</div>";
    echo "<pre>Stack trace:\n" . $e->getTraceAsString() . "</pre>";
}

echo "<h3>4. Información del entorno:</h3>";
echo "PHP Version: " . phpversion() . "<br>";
echo "cURL Version: " . (function_exists('curl_version') ? curl_version()['version'] : 'No disponible') . "<br>";
echo "OpenSSL Version: " . (defined('OPENSSL_VERSION_TEXT') ? OPENSSL_VERSION_TEXT : 'No disponible') . "<br>";
echo "User Agent: " . ($_SERVER['HTTP_USER_AGENT'] ?? 'CLI') . "<br>";
echo "Server Software: " . ($_SERVER['SERVER_SOFTWARE'] ?? 'No disponible') . "<br>";
?>
