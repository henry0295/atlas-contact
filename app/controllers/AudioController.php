<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Audio;

class AudioController extends Controller {
    private $audioModel;

    public function __construct() {
        // Verificar si el usuario está autenticado
        if(!isset($_SESSION['user_id'])) {
            $this->redirect('auth/login');
        }
        
        $this->audioModel = new Audio();
    }    public function index() {
        $this->view('audio/index');
    }

    public function send() {
        $data = [
            'errors' => [],
            'success' => null,
            'data' => []
        ];

        if($this->isPost()) {
            $postData = $this->getPost();
            $data['data'] = $postData;
            
            $errors = $this->validate($postData, [
                'recipient' => 'required',
                'message' => 'required'
            ]);

            if(empty($errors)) {                $result = $this->audioModel->send(
                    $postData['recipient'], 
                    $postData['message'],
                    $postData['gender'] ?? 'F',
                    $postData['language'] ?? 'es_ES',
                    $postData['campaign'] ?? 'Individual'
                );
                  if(isset($result['status']) && $result['status'] === 'success') {
                    $_SESSION['result'] = [
                        'status' => 'success',
                        'message' => $result['message'] ?? 'Mensaje de voz enviado correctamente'
                    ];
                    $this->redirect('audio/results');
                } else {
                    $errorMessage = $result['message'] ?? 'Error desconocido';
                    if (isset($result['debug'])) {
                        // En desarrollo, mostrar más detalles del error
                        $errorMessage .= " (Debug: " . substr($result['debug'], 0, 100) . "...)";
                    }
                    $data['errors']['send'] = 'Error al enviar el mensaje: ' . $errorMessage;
                }
            } else {
                $data['errors'] = $errors;
            }
        }
        
        $this->view('audio/send', $data);
    }    public function bulk() {
        $data = [
            'errors' => [],
            'success' => null,
            'data' => []
        ];

        if($this->isPost()) {
            $postData = $this->getPost();
            $data['data'] = $postData;
            
            $errors = $this->validate($postData, [
                'message' => 'required'
            ]);

            // Validar archivo CSV
            if (!isset($_FILES['csv_file']) || $_FILES['csv_file']['error'] !== UPLOAD_ERR_OK) {
                $errors['csv'] = 'Por favor, seleccione un archivo CSV válido';
            } else {
                $file = $_FILES['csv_file']['tmp_name'];
                $numbers = [];
                
                if (($handle = fopen($file, "r")) !== FALSE) {
                    // Saltar la primera línea si es encabezado
                    $header = fgetcsv($handle);
                    
                    while (($data_row = fgetcsv($handle)) !== FALSE) {
                        if (!empty($data_row[0])) {
                            $number = trim($data_row[0]);
                            // Validar formato del número (debe empezar con 57 y tener 12 dígitos)
                            if (preg_match('/^57\d{10}$/', $number)) {
                                $numbers[] = $number;
                            }
                        }
                    }
                    fclose($handle);
                } else {
                    $errors['csv'] = 'Error al leer el archivo CSV';
                }

                if (empty($numbers)) {
                    $errors['csv'] = 'No se encontraron números de teléfono válidos en el archivo';
                }
            }

            if(empty($errors)) {
                $result = $this->audioModel->sendBulk(
                    $numbers, 
                    $postData['message'],
                    $postData['gender'] ?? 'F',
                    $postData['language'] ?? 'es_ES'
                );
                
                if(isset($result['status']) && $result['status'] === 'success') {
                    $_SESSION['result'] = [
                        'status' => 'success',
                        'message' => 'Se han enviado ' . count($numbers) . ' mensajes de voz exitosamente'
                    ];
                    $this->redirect('audio/results');
                } else {
                    $data['errors']['send'] = 'Error al enviar los mensajes: ' . ($result['message'] ?? 'Error desconocido');
                }
            } else {
                $data['errors'] = $errors;
            }
        }
        
        $this->view('audio/bulk', $data);
    }public function results() {
        $result = $_SESSION['result'] ?? null;
        unset($_SESSION['result']);
        
        $logs = $this->audioModel->getLogs(10); // Obtener los últimos 10 envíos
        
        $this->view('audio/results', [
            'result' => $result,
            'logs' => $logs
        ]);
    }

    public function logs() {
        $logs = $this->audioModel->getLogs();
        $this->view('audio/logs', ['logs' => $logs]);
    }
}
