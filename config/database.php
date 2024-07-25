<?php

require_once 'env.php'; // Incluye el archivo de variables de entorno
loadEnv('../.env'); // Carga las variables de entorno
show(env('ENV_HOST'));

return
[
    'host' => env('DB_HOST', '127.0.0.1'),
    'dbname' => env('DB_DATABASE','programacion'),
    'username' => env('DB_USERNAME','root'),
    'password' => env('DB_PASSWORD',''),
    'port' => env('DB_PORT', '5432')
];
