<?php
namespace App\Models;

use App\Core\Model;

class Email extends Model {
    private $table = 'email_logs';
    private $api_url = 'https://dashboard.360nrs.com/api/rest/mailing';
    private $api_key = 'cmhhdGxhc3NlZ3VyaWRhOkdYZmIxOSUm'; // En producción, usar variable de entorno
    private $from_name = 'SOLDARCO';
    private $from_email = 'marketing@notificaciones.soldarco.com';
    private $reply_to = 'marketing@soldarco.com';

    public function __construct() {
        parent::__construct();
    }
    
    public function send($to, $subject, $body, $attachments = [], $campaignName = '') {
        $data = [
            'to' => [$to],
            'fromName' => $this->from_name,
            'fromEmail' => $this->from_email,
            'replyTo' => $this->reply_to,
            'subject' => $subject,
            'body' => $body,
            'campaignName' => $campaignName ?: 'MAIL_' . date('YmdHis'),
            'certified' => 'yes'
        ];

        $response = $this->makeApiRequest($data);
        
        // Registrar el envío
        $status = isset($response['status']) && $response['status'] === 'success' ? 'sent' : 'failed';
        $this->logEmail($to, $subject, $status, $response['message'] ?? null);

        return $response;
    }

    private function makeApiRequest($data) {
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
                'message' => $error
            ];
        }

        curl_close($ch);
        
        $result = json_decode($response, true);
        if (!$result) {
            return [
                'status' => 'error',
                'message' => 'Invalid API response'
            ];
        }

        return $result;
    }    public function sendBulk($recipients, $subject, $body, $attachments = [], $campaignName = '') {
        $data = [
            'to' => $recipients,
            'fromName' => $this->from_name,
            'fromEmail' => $this->from_email,
            'replyTo' => $this->reply_to,
            'subject' => $subject,
            'body' => $body,
            'campaignName' => $campaignName ?: 'MAIL_BULK_' . date('YmdHis'),
            'certified' => 'yes'
        ];

        $response = $this->makeApiRequest($data);
        
        // Registrar cada envío
        $status = isset($response['status']) && $response['status'] === 'success' ? 'sent' : 'failed';
        foreach ($recipients as $recipient) {
            $this->logEmail($recipient, $subject, $status, $response['message'] ?? null);
        }

        return $response;
    }

    private function logEmail($recipient, $subject, $status, $error = null) {
        $this->db->query('INSERT INTO ' . $this->table . ' (recipient, subject, status, error, created_at) 
                         VALUES (:recipient, :subject, :status, :error, NOW())');
        
        $this->db->bind(':recipient', $recipient);
        $this->db->bind(':subject', $subject);
        $this->db->bind(':status', $status);
        $this->db->bind(':error', $error);

        return $this->db->execute();
    }

    public function getLogs($limit = 100) {
        $this->db->query('SELECT * FROM ' . $this->table . ' ORDER BY created_at DESC LIMIT :limit');
        $this->db->bind(':limit', $limit);
        return $this->db->resultSet();
    }
    public function getStatistics() {
        $stats = [];
        
        // Total Emails
        $this->db->query('SELECT COUNT(*) as total FROM ' . $this->table);
        $stats['total'] = $this->db->single()->total ?? 0;
        
        // Emails exitosos
        $this->db->query("SELECT COUNT(*) as success FROM " . $this->table . " WHERE status = 'sent'");
        $stats['success'] = $this->db->single()->success ?? 0;
        
        // Emails fallidos
        $this->db->query("SELECT COUNT(*) as failed FROM " . $this->table . " WHERE status = 'failed'");
        $stats['failed'] = $this->db->single()->failed ?? 0;
        
        // Emails hoy
        $this->db->query('SELECT COUNT(*) as today FROM ' . $this->table . ' WHERE DATE(created_at) = CURDATE()');
        $stats['today'] = $this->db->single()->today ?? 0;
        
        return $stats;
    }

}
