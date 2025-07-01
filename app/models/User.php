<?php
namespace App\Models;

use App\Core\Model;

class User extends Model {
    private $table = 'users';

    public function create($data) {
        $this->db->query('INSERT INTO ' . $this->table . ' (username, password, email, role) VALUES (:username, :password, :email, :role)');
        
        // Hash password
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        
        // Bind values
        $this->db->bind(':username', $data['username']);
        $this->db->bind(':password', $data['password']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':role', $data['role'] ?? 'user');

        return $this->db->execute();
    }    public function login($username, $password) {
        try {
            $this->db->query('SELECT * FROM ' . $this->table . ' WHERE username = :username');
            $this->db->bind(':username', $username);

            $row = $this->db->single();

            if(!$row) {
                error_log("Usuario no encontrado: " . $username);
                return false;
            }

            $verified = password_verify($password, $row->password);
            error_log("Verificación de contraseña para " . $username . ": " . ($verified ? 'exitosa' : 'fallida'));

            if($verified) {
                return $row;
            }

            return false;
        } catch (\Exception $e) {
            error_log("Error en login: " . $e->getMessage());
            throw $e;
        }
    }

    public function findUserById($id) {
        $this->db->query('SELECT * FROM ' . $this->table . ' WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }
}
