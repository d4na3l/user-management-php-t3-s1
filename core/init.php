<?php
// Ejecuta por orden cada uno de los archivos dentro de Core, para que funcionen

spl_autoload_register(function ($classname) {
    // Llamar a las clases dentro de Model cuando son instanciadas.
    require $filename = "../app/models/" . ucfirst($classname) . ".php";
});

require 'Database.php';
require 'Model.php';
require 'Controller.php';
require 'App.php';
