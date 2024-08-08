<?php

namespace App\Controller;

use App\Model\User;

class HomeController
{
    public function index()
    {
        if (!isset($_SESSION['user'])) {
            // Redirigir al inicio de sesión si el usuario no está definido en la sesión
            header('Location: /login');
            exit;
        }

        $viewController = new ViewController();
        $viewController->render('home', $this->showAllUsers());
    }

    private function showAllUsers()
    {

        $userModel = new User();
        $loggedInUserId = $_SESSION['user']['id'];
        $users = $userModel->allExceptLoggedIn($loggedInUserId);

        if ($users === false) {
            $users = [];
        }

        // Convertir los resultados de stdClass a arrays
        $usersArray = array_map(function($user) {
            return (array) $user;
        }, $users);

        return $data = [
            'title' => 'Homepage',
            'users' => $usersArray
        ];
    }
}
