<?php
namespace App\Models;

use App\Core\Model;

class MessageModel extends Model {
    protected $table;
    protected $status_column = 'status';

    public function getLogsByDateRange($startDate, $endDate) {
        $this->db->query("SELECT * FROM {$this->table} 
                         WHERE DATE(created_at) BETWEEN :start_date AND :end_date 
                         ORDER BY created_at DESC");
        
        $this->db->bind(':start_date', $startDate);
        $this->db->bind(':end_date', $endDate);
        
        return $this->db->resultSet();
    }

    public function getStatsByDateRange($startDate, $endDate) {
        $this->db->query("SELECT 
                            DATE(created_at) as date,
                            COUNT(*) as total,
                            SUM(CASE WHEN {$this->status_column} = 'success' THEN 1 ELSE 0 END) as success,
                            SUM(CASE WHEN {$this->status_column} != 'success' THEN 1 ELSE 0 END) as failed
                         FROM {$this->table}
                         WHERE DATE(created_at) BETWEEN :start_date AND :end_date
                         GROUP BY DATE(created_at)
                         ORDER BY date DESC");
        
        $this->db->bind(':start_date', $startDate);
        $this->db->bind(':end_date', $endDate);
        
        return $this->db->resultSet();
    }

    public function getTotalCount() {
        $this->db->query("SELECT COUNT(*) as total FROM {$this->table}");
        $result = $this->db->single();
        return $result->total ?? 0;
    }

    public function getSuccessCount() {
        $this->db->query("SELECT COUNT(*) as total FROM {$this->table} 
                         WHERE {$this->status_column} = 'success'");
        $result = $this->db->single();
        return $result->total ?? 0;
    }

    public function getFailedCount() {
        $this->db->query("SELECT COUNT(*) as total FROM {$this->table} 
                         WHERE {$this->status_column} != 'success'");
        $result = $this->db->single();
        return $result->total ?? 0;
    }

    public function getTodayCount() {
        $this->db->query("SELECT COUNT(*) as total FROM {$this->table} 
                         WHERE DATE(created_at) = CURDATE()");
        $result = $this->db->single();
        return $result->total ?? 0;
    }
}
