<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Sms;

class SmsController extends Controller {
    private $smsModel;

    public function __construct() {
        // Verificar si el usuario está autenticado
        if(!isset($_SESSION['user_id'])) {
            $this->redirect('auth/login');
        }
        
        $this->smsModel = new Sms();
    }

    public function index() {
        $this->view('sms/index');
    }

    public function send() {
        $data = [
            'title' => 'Enviar SMS',
            'errors' => [],
            'success' => null,
            'post' => []
        ];

        if($this->isPost()) {
            $data['post'] = $postData = $this->getPost();
            
            $errors = $this->validate($postData, [
                'recipient' => 'required',
                'message' => 'required'
            ]);

            if(empty($errors)) {
                $campaign = $postData['campaign'] ?? '';
                $result = $this->smsModel->send($postData['recipient'], $postData['message'], $campaign);
                
                if($result && isset($result['status']) && $result['status'] === 'success') {
                    $data['success'] = 'Mensaje enviado correctamente';
                    $data['post'] = []; // Limpiar formulario después del éxito
                } else {
                    $data['errors']['send'] = 'Error al enviar el mensaje: ' . ($result['message'] ?? 'Error desconocido');
                }
            } else {
                $data['errors'] = $errors;
            }
        }
        
        $this->view('sms/send', $data);
    }

    public function bulk() {
        $data = [
            'title' => 'Envío Masivo de SMS',
            'errors' => [],
            'success' => null,
            'post' => []
        ];

        if($this->isPost()) {
            $data['post'] = $postData = $this->getPost();
            
            // Validar el archivo
            if(!isset($_FILES['contacts']) || $_FILES['contacts']['error'] !== UPLOAD_ERR_OK) {
                $data['errors']['file'] = 'Por favor, seleccione un archivo CSV válido';
            }
            
            // Validar el mensaje
            if(empty($postData['message'])) {
                $data['errors']['message'] = 'El mensaje es requerido';
            }

            if(empty($data['errors'])) {
                try {
                    $file = $_FILES['contacts']['tmp_name'];
                    $contacts = array_map('str_getcsv', file($file));
                    
                    // Verificar si el CSV tiene headers
                    $headers = array_map('strtolower', $contacts[0]);
                    $phoneIndex = array_search('phone', $headers);
                    
                    if($phoneIndex === false) {
                        // Si no hay header 'phone', asumir primera columna
                        $phoneIndex = 0;
                        $phoneNumbers = array_column($contacts, 0);
                    } else {
                        // Remover headers y obtener números
                        array_shift($contacts);
                        $phoneNumbers = array_column($contacts, $phoneIndex);
                    }
                    
                    $campaign = $postData['campaign'] ?? 'Masivo_' . date('YmdHis');
                    $successCount = 0;
                    $errors = [];
                    
                    foreach($phoneNumbers as $phone) {
                        if(!empty(trim($phone))) {
                            $result = $this->smsModel->send(trim($phone), $postData['message'], $campaign);
                            if($result && isset($result['status']) && $result['status'] === 'success') {
                                $successCount++;
                            } else {
                                $errors[] = "Error enviando a {$phone}";
                            }
                        }
                    }
                    
                    if($successCount > 0) {
                        $data['success'] = "Se enviaron {$successCount} mensajes exitosamente";
                        if(!empty($errors)) {
                            $data['errors']['partial'] = implode("<br>", $errors);
                        }
                        $data['post'] = []; // Limpiar formulario después del éxito
                    } else {
                        $data['errors']['send'] = 'Error al enviar los mensajes';
                    }
                    
                } catch (\Exception $e) {
                    $data['errors']['system'] = 'Error al procesar el archivo: ' . $e->getMessage();
                }
            }
        }
        
        $this->view('sms/bulk', $data);
    }

    public function results() {
        $result = $_SESSION['result'] ?? null;
        unset($_SESSION['result']);
        
        $this->view('sms/results', ['result' => $result]);
    }

    public function logs() {
        $filters = [
            'date_from' => $_GET['date_from'] ?? '',
            'date_to' => $_GET['date_to'] ?? '',
            'status' => $_GET['status'] ?? '',
            'campaign' => $_GET['campaign'] ?? ''
        ];
        
        $page = $_GET['page'] ?? 1;
        $result = $this->smsModel->getLogs($filters, $page);
        
        $data = [
            'logs' => $result['logs'],
            'total_pages' => $result['total_pages'],
            'current_page' => $result['current_page'],
            'filters' => $filters
        ];
        
        $this->view('sms/logs', $data);
    }
}
