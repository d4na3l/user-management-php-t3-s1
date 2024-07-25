<?php

namespace core;

trait Database
{
    private $config;

    // Constructor para cargar la configuración de la base de datos.
    public function __construct()
    {
        $this->config = require '../config/database.php';
    }

    // Metodo para conectar con la base de datos y comprobar que este funcionando.
    private function connect()
    {
        $string = 'pgsql:host=' . $this->config['host'] . ';port=' . $this->config['port'] . ';dbname=' . $this->config['dbname'];

        try {
            $con = new \PDO($string, $this->config['username'], $this->config['password']);
            $con->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            return $con;
        } catch (Exception $e) {
            die('Failure to connect to db: ' . $e->getMessage());
        }
    }

    // Metodo para Conectar con la base de datos destructurar el query, hacer la peticion a la base de datos y regresar los resultados en base al query.
    public function query($query, $data = [])
    {
        $con = $this->connect();
        $stm = $con->prepare($query);

        $check = $stm->execute($data);
        if ($check) {
            $result = $stm->fetchAll(\PDO::FETCH_OBJ);
            if (is_array($result) && count($result)) {
                return $result;
            }
        }

        return false;
    }
}
