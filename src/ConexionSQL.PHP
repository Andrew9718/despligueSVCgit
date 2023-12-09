<?php
require_once 'ConexionSQL.PHP';
class ConectarBD
{
    private $hostname = 'mariadb';
    private $database = 'produccion';
    private $user = 'andrew';
    private $password = 'produccion';
    private $charset = 'utf8';
    private $port = '3306';
    private $conexion;

    function getConexion()
    {
        try {

            $this->conexion = new PDO(
                'mysql:host=' . $this->hostname . ';port=' . $this->port .
                    ';dbname=' . $this->database . ';charset=' . $this->charset,
                $this->user,
                $this->password
            );


            $this->conexion->setAttribute(
                PDO::ATTR_ERRMODE,
                PDO::ERRMODE_EXCEPTION
            );
        } catch (PDOException $error) {
            echo "¡ERROR: !" . $error->getMessage();
            die();
        }
        return $this->conexion;
    }

    function cerrarConexion()
    {
        $this->conexion = null;
    }
}
