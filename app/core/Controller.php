<?php
namespace App\Core;

class Controller {    // Cargar modelo
    protected function model($model) {
        $modelClass = 'App\\Models\\' . $model;
        return new $modelClass();
    }

    // Cargar vista
    protected function view($view, $data = []) {
        if(file_exists(APPROOT . '/views/' . $view . '.php')) {
            require_once APPROOT . '/views/' . $view . '.php';
        } else {
            die('Vista no encontrada');
        }
    }

    // Redireccionar
    protected function redirect($url) {
        header('Location: ' . BASE_URL . $url);
        exit();
    }

    // Verificar si es una solicitud POST
    protected function isPost() {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }

    // Obtener datos POST
    protected function getPost() {
        return $_POST;
    }

    // Obtener datos GET
    protected function getGet() {
        return $_GET;
    }

    // Validar datos
    protected function validate($data, $rules) {
        $errors = [];
        foreach($rules as $field => $rule) {
            if(!isset($data[$field]) || empty($data[$field])) {
                $errors[$field] = 'El campo es requerido';
            }
        }
        return $errors;
    }
}
