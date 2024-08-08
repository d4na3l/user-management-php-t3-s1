<?php

namespace App\Controller;

use App\Model\User;

class ProfileController
{
    protected $userEmail;

    public function __construct()
    {
        $this->userEmail = $_GET['email'] ?? null;
    }

    public function show()
    {
        if (!isset($_SESSION['user'])) {
            header('Location: /login');
            exit;
        }

        if (!$this->userEmail) {
            header('Location: /404');
            exit;
        }

        $userModel = new User();
        $user = $userModel->findByEmail($this->userEmail);

        if (!$user) {
            header('Location: /404');
            exit;
        }

        $viewController = new ViewController();
        $viewController->render('profile', [
            'title' => 'Profile',
            'profileUser' => (array) $user
        ]);
    }

    public function updateName()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email'])) {
            $userModel = new User();
            $user = $userModel->findByEmail($this->userEmail);

            if ($user) {
                $name = $_POST['name'];
                $userModel->update($user['id'], ['name' => $name]);

                header("Location: /profile?email={$_POST['email']}");
                exit;
            }
        }

        header('Location: /404');
        exit;
    }

    public function updateEmail()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email'])) {
            $userModel = new User();
            $user = $userModel->findByEmail($this->userEmail);

            if ($user) {
                $email = $_POST['email'];
                $userModel->update($user['id'], ['email' => $email]);

                header("Location: /profile?email={$email}");
                exit;
            }
        }

        header('Location: /404');
        exit;
    }

    public function updatePassword()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email'])) {
            $userModel = new User();
            $user = $userModel->findByEmail($this->userEmail);

            if ($user) {
                $password = $_POST['password'];
                $confirmPassword = $_POST['confirm_password'];

                if ($password === $confirmPassword) {
                    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                    $userModel->update($user['id'], ['password' => $hashedPassword]);

                    header("Location: /profile?email={$_POST['email']}");
                    exit;
                } else {
                    // Manejar el error de contraseñas que no coinciden
                    echo "Passwords do not match.";
                }
            }
        }

        header('Location: /404');
        exit;
    }

    public function delete()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
            $userModel = new User();
            $userModel->delete($_POST['id']); // Asume que tienes un método delete en el modelo

            // Redirigir después de la eliminación
            header('Location: /home');
            exit;
        }

        header('Location: /404');
        exit;
    }
}
