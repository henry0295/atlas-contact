<?php
namespace App\Models;

use App\Core\Model;

class Audio extends Model {
    private $table = 'audio_logs';
    private $api_url = 'https://dashboard.360nrs.com/api/rest/voice';
    private $api_key = 'cmhhdGxhc3NlZ3VyaWRhOkdYZmIxOSUm'; // En producción, usar variable de entorno

    public function __construct() {
        parent::__construct();
    }    public function send($to, $message, $gender = 'F', $language = 'es_ES', $campaign = 'Individual') {
        // Validar parámetros
        if (empty($to) || empty($message)) {
            return [
                'status' => 'error',
                'message' => 'El número de teléfono y el mensaje son obligatorios'
            ];
        }

        // Asegurar que el número tenga el prefijo "57"
        $to = $this->formatPhoneNumber($to);
        
        // Validar el formato del número
        if (!preg_match('/^57\d{10}$/', $to)) {
            return [
                'status' => 'error',
                'message' => 'Formato de número inválido. Debe ser 57 seguido de 10 dígitos'
            ];
        }

        $data = [
            "to" => [$to],
            "message" => $message,
            "gender" => $gender,
            "language" => $language,
            "campaignName" => $campaign
        ];

        $response = $this->makeApiRequest($data);
        
        // Guardar log en la base de datos
        $this->logAudio($to, $message, json_encode($response), $response['status'] ?? 'error', $campaign);

        return $response;
    }

    public function sendBulk($numbers, $message, $gender = 'F', $language = 'es_ES', $campaign = 'Bulk') {
        $success = 0;
        $failed = 0;
        $results = [];

        foreach ($numbers as $number) {
            $result = $this->send($number, $message, $gender, $language, $campaign);
            if (isset($result['status']) && $result['status'] === 'success') {
                $success++;
            } else {
                $failed++;
            }
            $results[] = [
                'number' => $number,
                'status' => $result['status'] ?? 'error',
                'message' => $result['message'] ?? 'Unknown error'
            ];
        }

        return [
            'success' => $success,
            'failed' => $failed,
            'results' => $results
        ];
    }    private function makeApiRequest($data) {
        try {
            $ch = curl_init();
            if ($ch === false) {
                throw new \Exception('No se pudo inicializar cURL');
            }

            curl_setopt_array($ch, [
                CURLOPT_URL => $this->api_url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => json_encode($data),
                CURLOPT_HTTPHEADER => [
                    'Content-Type: application/json',
                    'Authorization: Basic ' . $this->api_key
                ],
                CURLOPT_TIMEOUT => 30,
                CURLOPT_SSL_VERIFYPEER => false // Solo para desarrollo, eliminar en producción
            ]);

            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            
            if (curl_errno($ch)) {
                throw new \Exception(curl_error($ch));
            }

            curl_close($ch);
            
            $result = json_decode($response, true);
            if ($result === null && json_last_error() !== JSON_ERROR_NONE) {
                throw new \Exception('Error al decodificar respuesta JSON: ' . json_last_error_msg());
            }            // Verificar la respuesta y estructura
            if ($httpCode < 200 || $httpCode >= 300) {
                return [
                    'status' => 'error',
                    'message' => 'Error HTTP ' . $httpCode . ': ' . ($result['message'] ?? 'Error desconocido'),
                    'debug' => $response // Guardar respuesta raw para debug
                ];
            }

            // Verificar la estructura de la respuesta
            if (!is_array($result)) {
                return [
                    'status' => 'error',
                    'message' => 'Respuesta inválida de la API',
                    'debug' => $response
                ];
            }

            // Si la API devuelve su propio estado, usarlo
            if (isset($result['code']) || isset($result['status'])) {
                $apiStatus = $result['code'] ?? $result['status'];
                // Convertir códigos numéricos o texto a success/error
                $isSuccess = in_array($apiStatus, [200, '200', 'success', 'ok', 'accepted']);
                
                return [
                    'status' => $isSuccess ? 'success' : 'error',
                    'message' => $result['message'] ?? ($isSuccess ? 'Mensaje enviado correctamente' : 'Error en el envío'),
                    'api_response' => $result
                ];
            }

            // Si no hay estado explícito, considerar HTTP 200 como éxito
            return [
                'status' => 'success',
                'message' => 'Mensaje enviado correctamente',
                'api_response' => $result
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Error en la petición: ' . $e->getMessage()
            ];
        }
    }private function formatPhoneNumber($number) {
        // Eliminar caracteres no numéricos
        $number = preg_replace('/[^0-9]/', '', $number);
        
        // Agregar prefijo '57' si no está presente
        if (substr($number, 0, 2) !== '57') {
            $number = '57' . $number;
        }
        
        return $number;
    }    private function logAudio($recipient, $message, $response, $status, $campaign) {
        $this->db->query('INSERT INTO ' . $this->table . ' (recipient, campaign, audio_file, response, status, created_at) 
                         VALUES (:recipient, :campaign, :audio_file, :response, :status, NOW())');
        
        $this->db->bind(':recipient', $recipient);
        $this->db->bind(':campaign', $campaign);
        $this->db->bind(':audio_file', $message);
        $this->db->bind(':response', $response);
        $this->db->bind(':status', $status);

        return $this->db->execute();
    }

    public function getLogs($limit = 100) {
        $this->db->query('SELECT * FROM ' . $this->table . ' ORDER BY created_at DESC LIMIT :limit');
        $this->db->bind(':limit', $limit);
        return $this->db->resultSet();
    }
    
    public function getStatistics() {
        $stats = [];
        
        // Total Audio
        $this->db->query('SELECT COUNT(*) as total FROM ' . $this->table);
        $stats['total'] = $this->db->single()->total ?? 0;
        
        // Audio exitosos
        $this->db->query("SELECT COUNT(*) as success FROM " . $this->table . " WHERE status = 'success'");
        $stats['success'] = $this->db->single()->success ?? 0;
        
        // Audio fallidos
        $this->db->query("SELECT COUNT(*) as failed FROM " . $this->table . " WHERE status != 'success'");
        $stats['failed'] = $this->db->single()->failed ?? 0;
        
        // Audio hoy
        $this->db->query('SELECT COUNT(*) as today FROM ' . $this->table . ' WHERE DATE(created_at) = CURDATE()');
        $stats['today'] = $this->db->single()->today ?? 0;
        
        return $stats;
    }
}
