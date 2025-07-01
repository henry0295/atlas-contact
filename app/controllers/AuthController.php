<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\User;

class AuthController extends Controller {
    private $userModel;    public function __construct() {
        $this->userModel = new User();
    }

    public function login() {
        // Si ya hay una sesión activa, redirigir al home
        if(isset($_SESSION['user_id'])) {
            $this->redirect('home');
            return;
        }

        if($this->isPost()) {
            $data = $this->getPost();
            $errors = [];

            // Validar input
            if(empty($data['username'])) {
                $errors['username'] = 'El usuario es requerido';
            }
            if(empty($data['password'])) {
                $errors['password'] = 'La contraseña es requerida';
            }

            if(empty($errors)) {
                try {
                    $user = $this->userModel->login($data['username'], $data['password']);

                    if($user) {
                        // Crear sesión
                        $_SESSION['user_id'] = $user->id;
                        $_SESSION['username'] = $user->username;
                        $_SESSION['role'] = $user->role;

                        // Regenerar ID de sesión por seguridad
                        session_regenerate_id(true);

                        $this->redirect('home');
                    } else {
                        $errors['login'] = 'Usuario o contraseña incorrectos';
                    }
                } catch (\Exception $e) {
                    $errors['system'] = 'Error del sistema. Por favor intente más tarde.';
                }
            }

            // Si hay errores, mostrar la vista con los errores
            return $this->view('auth/login', [
                'errors' => $errors,
                'username' => $data['username'] ?? ''
            ]);
        }

        // GET request - mostrar formulario
        return $this->view('auth/login');
    }

    public function register() {
        if($this->isPost()) {
            $data = $this->getPost();

            // Validar input
            $errors = $this->validate($data, [
                'username' => 'required',
                'email' => 'required|email',
                'password' => 'required|min:6'
            ]);

            if(empty($errors)) {
                if($this->userModel->create($data)) {
                    $this->redirect('auth/login');
                } else {
                    $errors['register'] = 'Error al crear el usuario';
                }
            }

            $this->view('auth/register', ['errors' => $errors]);
        } else {
            $this->view('auth/register');
        }
    }

    public function logout() {
        // Destruir todas las variables de sesión
        $_SESSION = array();

        // Destruir la sesión
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }

        session_destroy();

        // Redirigir al login
        $this->redirect('auth/login');
    }

    public function index() {
        // Redirigir a login si se accede a /auth o /auth/index
        $this->redirect('auth/login');
    }
}
