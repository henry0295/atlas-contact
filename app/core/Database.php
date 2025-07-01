<?php
namespace App\Core;

use PDO;
use PDOException;

class Database {
    private $host = DB_HOST;
    private $user = DB_USER;
    private $pass = DB_PASS;
    private $dbname = DB_NAME;

    private $dbh;
    private $stmt;
    private $error;    public function __construct() {
        $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname;
        $options = array(
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4"
        );

        try {
            $this->dbh = new PDO($dsn, $this->user, $this->pass, $options);
            if(defined('DEBUG') && DEBUG) {
                error_log("Conexión exitosa a la base de datos");
            }
        } catch(PDOException $e) {
            $this->error = $e->getMessage();
            error_log("Error de conexión a la base de datos: " . $this->error);
            if(defined('DEBUG') && DEBUG) {
                throw $e;
            }
            throw new \Exception("Error de conexión a la base de datos");
        }
    }

    // Preparar consulta
    public function query($sql) {
        $this->stmt = $this->dbh->prepare($sql);
    }

    // Vincular valores
    public function bind($param, $value, $type = null) {
        if(is_null($type)) {
            switch(true) {
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
            }
        }

        $this->stmt->bindValue($param, $value, $type);
    }

    // Ejecutar la consulta
    public function execute() {
        return $this->stmt->execute();
    }

    // Obtener todos los registros
    public function resultSet() {
        $this->execute();
        return $this->stmt->fetchAll(PDO::FETCH_OBJ);
    }    // Obtener un solo registro
    public function single() {
        try {
            if(defined('DEBUG') && DEBUG) {
                error_log("Ejecutando consulta: " . $this->stmt->queryString);
            }
            $this->execute();
            $result = $this->stmt->fetch(PDO::FETCH_OBJ);
            if(defined('DEBUG') && DEBUG) {
                error_log("Resultado de consulta: " . ($result ? json_encode($result) : "no encontrado"));
            }
            return $result;
        } catch (\PDOException $e) {
            error_log("Error en consulta: " . $e->getMessage());
            if(defined('DEBUG') && DEBUG) {
                throw $e;
            }
            return false;
        }
    }

    // Obtener cantidad de filas
    public function rowCount() {
        return $this->stmt->rowCount();
    }

    // Obtener último ID insertado
    public function lastInsertId() {
        return $this->dbh->lastInsertId();
    }

    // Iniciar transacción
    public function beginTransaction() {
        return $this->dbh->beginTransaction();
    }

    // Confirmar transacción
    public function commit() {
        return $this->dbh->commit();
    }

    // Revertir transacción
    public function rollBack() {
        return $this->dbh->rollBack();
    }
}
