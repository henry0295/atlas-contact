<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Email;

class EmailController extends Controller {
    private $emailModel;

    public function __construct() {
        // Verificar si el usuario está autenticado
        if(!isset($_SESSION['user_id'])) {
            $this->redirect('auth/login');
        }
        
        $this->emailModel = new Email();
    }

    public function index() {
        $this->view('email/index');
    }

    public function send() {
        $data = [
            'title' => 'Enviar Correo',
            'errors' => [],
            'success' => null,
            'post' => []
        ];

        if($this->isPost()) {
            $data['post'] = $postData = $this->getPost();
            
            $errors = $this->validate($postData, [
                'to' => 'required|email',
                'subject' => 'required',
                'message' => 'required'
            ]);

            if(empty($errors)) {
                $campaign = $postData['campaign'] ?? '';
                $result = $this->emailModel->send(
                    $postData['to'],
                    $postData['subject'],
                    $postData['message'],
                    $campaign
                );
                
                if($result && isset($result['status']) && $result['status'] === 'success') {
                    $data['success'] = 'Correo enviado correctamente';
                    $data['post'] = []; // Limpiar el formulario
                } else {
                    $data['errors']['send'] = 'Error al enviar el correo: ' . ($result['message'] ?? 'Error desconocido');
                }
            } else {
                $data['errors'] = $errors;
            }
        }
        
        $this->view('email/send', $data);
    }

    public function bulk() {
        $data = [
            'title' => 'Envío Masivo de Correos',
            'errors' => [],
            'success' => null,
            'post' => []
        ];

        if($this->isPost()) {
            $data['post'] = $postData = $this->getPost();
            
            $errors = $this->validate($postData, [
                'subject' => 'required',
                'message' => 'required'
            ]);

            // Validar archivo CSV
            if (!isset($_FILES['csv_file']) || $_FILES['csv_file']['error'] !== UPLOAD_ERR_OK) {
                $errors['csv'] = 'Por favor, seleccione un archivo CSV válido';
            } else {
                $file = $_FILES['csv_file']['tmp_name'];
                $emails = [];
                
                if (($handle = fopen($file, "r")) !== FALSE) {
                    // Saltar la primera línea si es encabezado
                    $header = fgetcsv($handle);
                    
                    while (($data_row = fgetcsv($handle)) !== FALSE) {
                        if (!empty($data_row[0])) {
                            $email = trim($data_row[0]);
                            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                                $emails[] = $email;
                            }
                        }
                    }
                    fclose($handle);
                } else {
                    $errors['csv'] = 'Error al leer el archivo CSV';
                }

                if (empty($emails)) {
                    $errors['csv'] = 'No se encontraron correos electrónicos válidos en el archivo';
                }
            }

            if(empty($errors)) {
                $result = $this->emailModel->sendBulk(
                    $emails,
                    $postData['subject'],
                    $postData['message']
                );
                  if($result && isset($result['status']) && $result['status'] === 'success') {
                    $_SESSION['result'] = [
                        'status' => 'success',
                        'message' => 'Se han enviado ' . count($emails) . ' correos exitosamente'
                    ];
                    $this->redirect('email/results');
                } else {
                    $_SESSION['result'] = [
                        'status' => 'error',
                        'message' => 'Error al enviar los correos: ' . ($result['message'] ?? 'Error desconocido')
                    ];
                    $this->redirect('email/results');
                }
            } else {
                $data['errors'] = $errors;
                $this->view('email/bulk', $data);
            }
        } else {
            $this->view('email/bulk', $data);
        }
    }    public function results() {
        // Si no hay resultados en sesión, mostraremos el historial de logs
        $logs = $this->emailModel->getLogs(10); // Obtener los últimos 10 envíos
        
        if (isset($_SESSION['result'])) {
            $result = $_SESSION['result'];
            unset($_SESSION['result']);
        } else {
            $result = null;
        }
        
        $this->view('email/results', [
            'result' => $result,
            'logs' => $logs
        ]);
    }

    public function logs() {
        $logs = $this->emailModel->getLogs();
        $this->view('email/logs', ['logs' => $logs]);
    }
}
