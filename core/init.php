<?php
// Ejecuta por orden cada uno de los archivos dentro de Core, para que funcionen

spl_autoload_register(function ($classname) {
    // Convierte el namespace en una ruta de archivo
    $filename = '../App/Model/' . str_replace('\\', '/', $classname) . '.php';
  if (file_exists($filename)) {
        require $filename;
    }
});

require 'functions.php';
require 'Database.php';
require 'Model.php';
// require 'Controller.php';
// require 'App.php';
