<?php
// Registro de autoload para cargar clases automáticamente
spl_autoload_register(function ($classname) {
    $filename = '../' . str_replace('\\', '/', $classname) . '.php';
    if (file_exists($filename)) {
        require $filename;
    }
});

// Incluir archivos necesarios
require 'functions.php';
require_once 'Database.php';
require_once 'Model.php';
require_once 'Controller.php';
require_once 'App.php';

// Iniciar la sesión si no está ya iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$csrf_token = $_SESSION['csrf_token'];

// Carga de clases adicionales
require 'Route.php';
