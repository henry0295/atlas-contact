<?php
// Script de depuración para SMS API
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h2>Diagnóstico de SMS API</h2>";

// Probar conexión con la API
$api_url = 'https://dashboard.360nrs.com/api/rest/sms';
$api_key = 'cmhhdGxhc3NlZ3VyaWRhOkdYZmIxOSUm';

echo "<h3>1. Configuración:</h3>";
echo "URL: " . $api_url . "<br>";
echo "API Key: " . substr($api_key, 0, 10) . "...<br>";

echo "<h3>2. Prueba de conectividad:</h3>";

// Verificar si cURL está disponible
if (!function_exists('curl_init')) {
    echo "<span style='color:red'>ERROR: cURL no está disponible</span><br>";
    exit;
}
echo "<span style='color:green'>✓ cURL está disponible</span><br>";

// Datos de prueba
$testData = [
    "to" => ["573005462640"],
    "from" => "Atlasrh",
    "campaignName" => "TEST_" . date('YmdHis'),
    "message" => "Mensaje de prueba",
    "parts" => 1,
    "trans" => 1,
    "splitParts" => false
];

echo "<h3>3. Datos de prueba:</h3>";
echo "<pre>" . json_encode($testData, JSON_PRETTY_PRINT) . "</pre>";

echo "<h3>4. Enviando solicitud...</h3>";

$ch = curl_init();
curl_setopt_array($ch, [
    CURLOPT_URL => $api_url,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS => json_encode($testData),
    CURLOPT_HTTPHEADER => [
        'Content-Type: application/json',
        'Authorization: Basic ' . $api_key
    ],
    CURLOPT_TIMEOUT => 30,
    CURLOPT_SSL_VERIFYPEER => false, // Solo para debugging
    CURLOPT_VERBOSE => true
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$curlError = curl_error($ch);

echo "<h3>5. Respuesta:</h3>";
echo "HTTP Code: " . $httpCode . "<br>";

if ($curlError) {
    echo "<span style='color:red'>cURL Error: " . $curlError . "</span><br>";
} else {
    echo "<span style='color:green'>✓ Sin errores de cURL</span><br>";
}

echo "<h3>6. Respuesta de la API:</h3>";
echo "<pre>" . htmlspecialchars($response) . "</pre>";

curl_close($ch);

// Intentar decodificar la respuesta
if ($response) {
    $decoded = json_decode($response, true);
    if ($decoded) {
        echo "<h3>7. Respuesta decodificada:</h3>";
        echo "<pre>" . json_encode($decoded, JSON_PRETTY_PRINT) . "</pre>";
    } else {
        echo "<span style='color:red'>ERROR: No se pudo decodificar la respuesta JSON</span><br>";
    }
}
?>
