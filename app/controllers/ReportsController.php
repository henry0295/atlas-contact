<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Sms;
use App\Models\Email;
use App\Models\Audio;

class ReportsController extends Controller {
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
        $data = [
            'title' => 'Reportes Generales',
            'sms_stats' => $this->smsModel->getStatistics(),
            'email_stats' => $this->emailModel->getStatistics(),
            'audio_stats' => $this->audioModel->getStatistics()
        ];
        
        $this->view('reports/index', $data);
    }
}
