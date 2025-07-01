<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Sms;
use App\Models\Email;
use App\Models\Audio;

class ReportController extends Controller {
    private $smsModel;
    private $emailModel;
    private $audioModel;

    public function __construct() {
        // Verificar si el usuario está autenticado
        if(!isset($_SESSION['user_id'])) {
            $this->redirect('auth/login');
        }
        
        $this->smsModel = new Sms();
        $this->emailModel = new Email();
        $this->audioModel = new Audio();
    }

    public function index() {
        // Obtener estadísticas generales
        $stats = $this->getGeneralStats();
        
        // Obtener actividad reciente
        $recentActivity = $this->getRecentActivity();
        
        $this->view('reports/dashboard', [
            'stats' => $stats,
            'recentActivity' => $recentActivity
        ]);
    }

    public function sms() {
        $startDate = $_GET['start_date'] ?? date('Y-m-d', strtotime('-30 days'));
        $endDate = $_GET['end_date'] ?? date('Y-m-d');
        
        $logs = $this->smsModel->getLogsByDateRange($startDate, $endDate);
        $stats = $this->smsModel->getStatsByDateRange($startDate, $endDate);
        
        $this->view('reports/sms', [
            'logs' => $logs,
            'stats' => $stats,
            'startDate' => $startDate,
            'endDate' => $endDate
        ]);
    }

    public function email() {
        $startDate = $_GET['start_date'] ?? date('Y-m-d', strtotime('-30 days'));
        $endDate = $_GET['end_date'] ?? date('Y-m-d');
        
        $logs = $this->emailModel->getLogsByDateRange($startDate, $endDate);
        $stats = $this->emailModel->getStatsByDateRange($startDate, $endDate);
        
        $this->view('reports/email', [
            'logs' => $logs,
            'stats' => $stats,
            'startDate' => $startDate,
            'endDate' => $endDate
        ]);
    }

    public function audio() {
        $startDate = $_GET['start_date'] ?? date('Y-m-d', strtotime('-30 days'));
        $endDate = $_GET['end_date'] ?? date('Y-m-d');
        
        $logs = $this->audioModel->getLogsByDateRange($startDate, $endDate);
        $stats = $this->audioModel->getStatsByDateRange($startDate, $endDate);
        
        $this->view('reports/audio', [
            'logs' => $logs,
            'stats' => $stats,
            'startDate' => $startDate,
            'endDate' => $endDate
        ]);
    }

    public function export() {
        $type = $_GET['type'] ?? 'sms';
        $format = $_GET['format'] ?? 'excel';
        $startDate = $_GET['start_date'] ?? date('Y-m-d', strtotime('-30 days'));
        $endDate = $_GET['end_date'] ?? date('Y-m-d');

        switch($type) {
            case 'sms':
                $data = $this->smsModel->getLogsByDateRange($startDate, $endDate);
                break;
            case 'email':
                $data = $this->emailModel->getLogsByDateRange($startDate, $endDate);
                break;
            case 'audio':
                $data = $this->audioModel->getLogsByDateRange($startDate, $endDate);
                break;
            default:
                $this->redirect('reports');
                return;
        }

        if($format === 'excel') {
            $this->exportToExcel($data, $type);
        } else {
            $this->exportToCsv($data, $type);
        }
    }

    private function getGeneralStats() {
        return [
            'sms' => [
                'total' => $this->smsModel->getTotalCount(),
                'success' => $this->smsModel->getSuccessCount(),
                'failed' => $this->smsModel->getFailedCount(),
                'today' => $this->smsModel->getTodayCount()
            ],
            'email' => [
                'total' => $this->emailModel->getTotalCount(),
                'success' => $this->emailModel->getSuccessCount(),
                'failed' => $this->emailModel->getFailedCount(),
                'today' => $this->emailModel->getTodayCount()
            ],
            'audio' => [
                'total' => $this->audioModel->getTotalCount(),
                'success' => $this->audioModel->getSuccessCount(),
                'failed' => $this->audioModel->getFailedCount(),
                'today' => $this->audioModel->getTodayCount()
            ]
        ];
    }

    private function getRecentActivity() {
        $recentSms = $this->smsModel->getLogs(5);
        $recentEmail = $this->emailModel->getLogs(5);
        $recentAudio = $this->audioModel->getLogs(5);

        return [
            'sms' => $recentSms,
            'email' => $recentEmail,
            'audio' => $recentAudio
        ];
    }

    private function exportToExcel($data, $type) {
        require_once APP_ROOT . '/vendor/autoload.php';

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        // Establecer encabezados según el tipo
        switch($type) {
            case 'sms':
                $headers = ['Fecha', 'Número', 'Mensaje', 'Estado', 'Respuesta'];
                break;
            case 'email':
                $headers = ['Fecha', 'Correo', 'Asunto', 'Estado', 'Error'];
                break;
            case 'audio':
                $headers = ['Fecha', 'Número', 'Audio', 'Estado', 'Respuesta'];
                break;
        }

        // Escribir encabezados
        $col = 'A';
        foreach($headers as $header) {
            $sheet->setCellValue($col++ . '1', $header);
        }

        // Escribir datos
        $row = 2;
        foreach($data as $item) {
            $col = 'A';
            foreach($item as $value) {
                $sheet->setCellValue($col++ . $row, $value);
            }
            $row++;
        }

        // Configurar el tipo de respuesta
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="reporte_' . $type . '_' . date('Y-m-d') . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }

    private function exportToCsv($data, $type) {
        // Configurar el tipo de respuesta
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment;filename="reporte_' . $type . '_' . date('Y-m-d') . '.csv"');
        
        // Crear archivo CSV
        $output = fopen('php://output', 'w');
        
        // Establecer encabezados según el tipo
        switch($type) {
            case 'sms':
                $headers = ['Fecha', 'Número', 'Mensaje', 'Estado', 'Respuesta'];
                break;
            case 'email':
                $headers = ['Fecha', 'Correo', 'Asunto', 'Estado', 'Error'];
                break;
            case 'audio':
                $headers = ['Fecha', 'Número', 'Audio', 'Estado', 'Respuesta'];
                break;
        }

        // Escribir encabezados
        fputcsv($output, $headers);

        // Escribir datos
        foreach($data as $item) {
            fputcsv($output, (array)$item);
        }

        fclose($output);
        exit;
    }
}
