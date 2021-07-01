<?php
require 'config.php';

class Conexion_pdo
{
    protected $conexion_db;

    public function __construct()
    {
        try {
            $cadena_conexion = "mysql:host=" . DB_HOST . "; dbname=" . DB_NAME;
            $this->conexion_db = new PDO($cadena_conexion, DB_USUARIO, DB_PASS);
            $this->conexion_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conexion_db->exec("SET CHARACTER SET " . DB_CHARSET);
            return $this->conexion_db;
        } catch (Exception $e) {
            echo 'el problema es en: ' . $e->getLine();
        }

    }
}

?>