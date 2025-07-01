<?php
namespace App\Core;

class App {
    protected $controller = 'HomeController';
    protected $method = 'index';
    protected $params = [];

    public function __construct() {
        try {
            $url = $this->parseUrl();

            // Si no hay URL, usar los valores por defecto
            if (!$url) {
                $url = [];
            }

            // Verificar y cargar el controlador
            if(isset($url[0])) {
                $controllerName = ucfirst($url[0]) . 'Controller';
                $controllerClass = 'App\\Controllers\\' . $controllerName;
                
                if(class_exists($controllerClass)) {
                    $this->controller = $controllerName;
                    unset($url[0]);
                }
            }

            // Crear instancia del controlador
            $controllerClass = 'App\\Controllers\\' . $this->controller;
            
            if(!class_exists($controllerClass)) {
                error_log("Controller not found: " . $controllerClass);
                throw new \Exception("Controller not found: " . $controllerClass);
            }

            // Verificar si el método existe en la clase
            if (!method_exists($controllerClass, $this->method)) {
                error_log("Method not found: " . $controllerClass . "->" . $this->method);
                throw new \Exception("Method not found: " . $controllerClass . "->" . $this->method);
            }
            
            $this->controller = new $controllerClass();

            // Verificar y cargar el método
            if(isset($url[1])) {
                if(method_exists($this->controller, $url[1])) {
                    $this->method = $url[1];
                    unset($url[1]);
                }
            }

            // Obtener parámetros
            $this->params = $url ? array_values($url) : [];

            // Llamar al método del controlador con los parámetros
            call_user_func_array([$this->controller, $this->method], $this->params);
            
        } catch (\Exception $e) {
            error_log("Error in App: " . $e->getMessage());
            error_log("Stack trace: " . $e->getTraceAsString());
            
            if(defined('DEBUG') && DEBUG === true) {
                throw $e;
            }
            
            // Redirigir al login en caso de error
            header('Location: ' . BASE_URL . 'auth/login');
            exit;
        }
    }

    protected function parseUrl() {
        if(isset($_GET['url'])) {
            return explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
        }
        return [];
    }
}
