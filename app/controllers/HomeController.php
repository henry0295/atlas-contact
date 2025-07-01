<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Sms;
use App\Models\Email;
use App\Models\Audio;

class HomeController extends Controller {
    private $smsModel;
    private $emailModel;
    private $audioModel;

    public function __construct() {
        // Verificar autenticación excepto para ciertas rutas
        $publicRoutes = ['auth/login', 'auth/register'];
        $currentRoute = isset($_GET['url']) ? $_GET['url'] : '';
        
        if (!in_array($currentRoute, $publicRoutes) && !isset($_SESSION['user_id'])) {
            $this->redirect('auth/login');
        }

        $this->smsModel = new Sms();
        $this->emailModel = new Email();
        $this->audioModel = new Audio();
    }

    public function index() {
        // Verificar autenticación para el dashboard
        if(!isset($_SESSION['user_id'])) {
            $this->redirect('auth/login');
            return;
        }

        // Obtener estadísticas
        $stats = $this->getStatistics();
        
        $data = [
            'title' => 'Dashboard',
            'username' => $_SESSION['username'] ?? '',
            'role' => $_SESSION['role'] ?? '',
            'stats' => $stats
        ];
        
        $this->view('home/index', $data);
    }

    private function getStatistics() {
        // Estadísticas de SMS
        $smsStats = $this->smsModel->getStatistics();
        
        // Estadísticas de Email
        $emailStats = $this->emailModel->getStatistics();
        
        // Estadísticas de Audio
        $audioStats = $this->audioModel->getStatistics();

        return [
            'sms' => $smsStats,
            'email' => $emailStats,
            'audio' => $audioStats,
            'totals' => [
                'total_messages' => $smsStats['total'] + $emailStats['total'] + $audioStats['total'],
                'total_success' => $smsStats['success'] + $emailStats['success'] + $audioStats['success'],
                'total_failed' => $smsStats['failed'] + $emailStats['failed'] + $audioStats['failed']
            ]
        ];
    }
}
