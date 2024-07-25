<?php

return
[
    'host' => env('ENV_HOST', '127.0.0.1'),
    'dbname' => env('DB_DATABASE','postgres'),
    'username' => env('DB_USERNAME','root'),
    'password' => env('DB_USERNAME',''),
    'port' => env('DB_PORT', '5432')
];

