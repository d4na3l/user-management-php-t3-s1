<?php

// trait Database, encargada de conectar con la base de datos.
trait Database
{
    private $config;

    // Constructor para cargar la configuración de la base de datos.
    public function __construct()
    {
        $this->config = require __DIR__ . '/../config/database.php';
    }

    // Metodo para conectar con la base de datos y comprobar que este funcionando.
    private function connect()
    {
        $dsn = 'pgsql:host=' . $this->config['host'] . ';port=' . $this->config['port'] . ';dbname=' . $this->config['dbname'];

        try {
            $con = new PDO($dsn, $this->config['username'], $this->config['password']);
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $con;
        } catch (Exception $e) {
            echo 'Failure to connect to db: ' . $e->getMessage();
        }
    }

    // Estructurar el query, hacer la peticion a la base de datos y regresar los resultados.
    public function query($query, $data = [])
    {
        $con = $this->connect();
        $stm = $con->prepare($query);

        $check = $stm->execute($data);
        if ($check) {
            $result = $stm->fetchAll(PDO::FETCH_OBJ);
            if (is_array($result) && count($result)) {
                return $result;
            }
        }

        return false;
    }

}
