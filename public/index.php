<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require '../core/init.php';
show('Hola mundo');

$userModel = new User;

$users = $userModel->read();
show($users);
