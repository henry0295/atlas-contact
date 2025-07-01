<?php
namespace App\Models;

use App\Core\Model;

class Sms extends Model {
    private $table = 'sms_logs';
    private $api_url = 'https://dashboard.360nrs.com/api/rest/sms';
    private $api_key = 'cmhhdGxhc3NlZ3VyaWRhOkdYZmIxOSUm'; // En producción, usar variable de entorno
    private $sender_id = 'Atlasrh';    public function __construct() {
        parent::__construct();
    }

    private function formatPhoneNumber($number) {
        // Eliminar caracteres no numéricos
        $number = preg_replace('/[^0-9]/', '', $number);
          // Agregar prefijo '57' si no está presente
        if (substr($number, 0, 2) !== '57') {
            $number = '57' . $number;
        }
        
        return $number;
    }

    public function send($to, $message, $campaignName = '') {
        // Asegurar que el número tenga el prefijo "57"
        $to = $this->formatPhoneNumber($to);
        
        // Calcular el número de partes del mensaje
        $messageLength = mb_strlen($message);
        $parts = 1;
        
        // Verificar si hay caracteres especiales
        $containsSpecialChars = strlen($message) != mb_strlen($message, 'ASCII');
        
        if ($containsSpecialChars) {
            // UTF-16: 67 caracteres por parte
            $parts = ceil($messageLength / 67);
        } else {
            // GSM: 153 caracteres por parte
            $parts = ceil($messageLength / 153);
        }
        
        // Limitar a un máximo de 15 partes según la API
        $parts = min($parts, 15);        $data = [
            "to" => [$to],
            "from" => $this->sender_id,
            "campaignName" => $campaignName ?: 'SMS_' . date('YmdHis'),
            "message" => $message,
            "parts" => $parts,
            "trans" => 1,
            "splitParts" => false
        ];        $response = $this->makeApiRequest($data);
        
        // Guardar log en la base de datos
        $this->logSms($to, $message, json_encode($response), $response['status'] ?? 'error', $campaignName ?: 'Individual');

        return $response;
    }    private function makeApiRequest($data) {
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $this->api_url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Authorization: Basic ' . $this->api_key
            ]
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        
        if (curl_errno($ch)) {
            $error = curl_error($ch);
            curl_close($ch);
            return [
                'status' => 'error',
                'message' => $error,
                'code' => $httpCode
            ];
        }

        curl_close($ch);
        
        $result = json_decode($response, true);
        if (!$result) {
            return [
                'status' => 'error',
                'message' => 'Invalid API response',
                'code' => $httpCode
            ];
        }

        return $result;
    }

    public function sendBulk($numbers, $message, $campaignName = '') {
        // Preparar todos los números
        $formattedNumbers = array_map([$this, 'formatPhoneNumber'], $numbers);
        
        // Calcular partes del mensaje
        $messageLength = mb_strlen($message);
        $parts = 1;
        
        $containsSpecialChars = strlen($message) != mb_strlen($message, 'ASCII');
        
        if ($containsSpecialChars) {
            $parts = ceil($messageLength / 67);
        } else {
            $parts = ceil($messageLength / 153);
        }
        
        $parts = min($parts, 15);

        // Enviar a todos los números en una sola llamada
        $data = [
            "to" => $formattedNumbers,
            "from" => $this->sender_id,
            "campaignName" => $campaignName ?: 'SMS_BULK_' . date('YmdHis'),
            "message" => $message,
            "parts" => $parts,
            "trans" => 1,
            "splitParts" => false
        ];

        $response = $this->makeApiRequest($data);
          // Registrar cada envío
        foreach ($formattedNumbers as $number) {
            $this->logSms($number, $message, json_encode($response), $response['status'] ?? 'error', $campaignName ?: 'Bulk');
        }

        return $response;
    }    private function logSms($to, $message, $response, $status, $campaign = 'Individual') {
        $this->db->query('INSERT INTO ' . $this->table . ' (recipient, campaign, message, response, status, created_at) VALUES (:recipient, :campaign, :message, :response, :status, NOW())');
        
        $this->db->bind(':recipient', $to);
        $this->db->bind(':campaign', $campaign);
        $this->db->bind(':message', $message);
        $this->db->bind(':response', $response);
        $this->db->bind(':status', $status);

        return $this->db->execute();
    }

    public function getLogs($filters = [], $page = 1, $limit = 50) {
        $offset = ($page - 1) * $limit;
        $where_conditions = [];
        $bind_params = [];
        
        // Filtro por fecha desde
        if (!empty($filters['date_from'])) {
            $where_conditions[] = "DATE(created_at) >= :date_from";
            $bind_params[':date_from'] = $filters['date_from'];
        }
        
        // Filtro por fecha hasta
        if (!empty($filters['date_to'])) {
            $where_conditions[] = "DATE(created_at) <= :date_to";
            $bind_params[':date_to'] = $filters['date_to'];
        }
        
        // Filtro por estado
        if (!empty($filters['status'])) {
            $where_conditions[] = "status = :status";
            $bind_params[':status'] = $filters['status'];
        }
        
        // Filtro por campaña
        if (!empty($filters['campaign'])) {
            $where_conditions[] = "campaign LIKE :campaign";
            $bind_params[':campaign'] = '%' . $filters['campaign'] . '%';
        }
        
        // Construir query
        $where_clause = empty($where_conditions) ? '' : 'WHERE ' . implode(' AND ', $where_conditions);
        
        // Query principal
        $query = "SELECT * FROM {$this->table} {$where_clause} ORDER BY created_at DESC LIMIT :limit OFFSET :offset";
        $this->db->query($query);
        
        // Bind de parámetros de filtros
        foreach ($bind_params as $param => $value) {
            $this->db->bind($param, $value);
        }
        
        // Bind de parámetros de paginación
        $this->db->bind(':limit', $limit);
        $this->db->bind(':offset', $offset);
        
        $logs = $this->db->resultSet();
        
        // Query para contar total de registros
        $count_query = "SELECT COUNT(*) as total FROM {$this->table} {$where_clause}";
        $this->db->query($count_query);
        
        // Bind de parámetros de filtros para el conteo
        foreach ($bind_params as $param => $value) {
            $this->db->bind($param, $value);
        }
        
        $total_records = $this->db->single()->total ?? 0;
        $total_pages = ceil($total_records / $limit);
        
        return [
            'logs' => $logs,
            'total_records' => $total_records,
            'total_pages' => $total_pages,
            'current_page' => $page
        ];
    }
    
    public function getStatistics() {
        $stats = [];
        
        // Total SMS
        $this->db->query('SELECT COUNT(*) as total FROM ' . $this->table);
        $stats['total'] = $this->db->single()->total ?? 0;
        
        // SMS exitosos
        $this->db->query("SELECT COUNT(*) as success FROM " . $this->table . " WHERE status = 'success'");
        $stats['success'] = $this->db->single()->success ?? 0;
        
        // SMS fallidos
        $this->db->query("SELECT COUNT(*) as failed FROM " . $this->table . " WHERE status != 'success'");
        $stats['failed'] = $this->db->single()->failed ?? 0;
        
        // SMS hoy
        $this->db->query('SELECT COUNT(*) as today FROM ' . $this->table . ' WHERE DATE(created_at) = CURDATE()');
        $stats['today'] = $this->db->single()->today ?? 0;
        
        return $stats;
    }
}
