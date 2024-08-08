<?php

namespace App\Controller;

use App\Model\User;

class AuthController
{
    public function showLoginForm($error = '')
    {
        $viewController = new ViewController();
        $viewController->render('login', ['name' => 'login', 'error' => $error]);
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? null;
            $password = $_POST['password'] ?? null;

            $error = '';
            if ($this->authenticate($email, $password, $error)) {
                $_SESSION['logged_in'] = true;
                $_SESSION['user'] = (array) (new User())->findByEmail($email);
                header('Location: /home');
                exit;
            } else {
                $this->showLoginForm($error);
            }
        } else {
            $this->showLoginForm();
        }
    }

    public function showRegisterForm($data = [])
    {
        $csrf_token = bin2hex(random_bytes(32));
        $_SESSION['csrf_token'] = $csrf_token;

        $viewController = new ViewController();
        $viewController->render('register', array_merge(['csrf_token' => $csrf_token], $data));
    }

    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? null;
            $email = $_POST['email'] ?? null;
            $password = $_POST['password'] ?? null;
            $confirmPassword = $_POST['confirm_password'] ?? null;

            if (empty($name) || empty($email) || empty($password) || empty($confirmPassword)) {
                $this->showRegisterForm(['error' => 'Todos los campos son requeridos.']);
                return;
            }

            if ($password !== $confirmPassword) {
                $this->showRegisterForm(['error' => 'Las contraseñas no coinciden.']);
                return;
            }

            $user = new User();
            $user->name = $name;
            $user->email = $email;
            $user->password = password_hash($password, PASSWORD_BCRYPT);
            $user->save();

            header('Location: /login');
            exit;
        } else {
            $this->showRegisterForm();
        }
    }

    public function showForgotPasswordForm()
    {
        $viewController = new ViewController();
        $viewController->render('forgot-password', ['name' => 'Olvidé mi contraseña']);
    }

    public function sendResetLink()
    {
        $email = $_POST['email'] ?? null;

        if ($email) {
            $user = (new User())->first(['email' => $email]);
            if ($user) {
                $token = bin2hex(random_bytes(50));
                $_SESSION['reset_token'] = $token;
                $_SESSION['reset_email'] = $email;

                // Send the reset link (For demonstration purposes, we're just outputting it)
                echo "Enlace para restablecer la contraseña: /reset-password?token=$token";
            } else {
                echo "Correo electrónico no encontrado.";
            }
        }
    }

    public function showResetPasswordForm()
    {
        $token = $_GET['token'] ?? null;

        if ($token && isset($_SESSION['reset_token']) && $_SESSION['reset_token'] === $token) {
            $viewController = new ViewController();
            $viewController->render('reset-password', ['name' => 'Restablecer contraseña']);
        } else {
            echo "Token inválido o expirado.";
        }
    }

    public function resetPassword()
    {
        $token = $_POST['token'] ?? null;
        $password = $_POST['password'] ?? null;
        $confirmPassword = $_POST['confirm_password'] ?? null;

        if ($token && isset($_SESSION['reset_token']) && $_SESSION['reset_token'] === $token) {
            if ($password !== $confirmPassword) {
                echo "Las contraseñas no coinciden.";
                return;
            }

            $email = $_SESSION['reset_email'] ?? null;
            $user = (new User())->first(['email' => $email]);

            if ($user) {
                $user->password = password_hash($password, PASSWORD_BCRYPT);
                $user->update($user->id, ['password' => $user->password]);
                echo "Contraseña restablecida con éxito.";
            } else {
                echo "Usuario no encontrado.";
            }
        } else {
            echo "Token inválido o expirado.";
        }
    }

    public function logout()
    {
        session_destroy();
        header('Location: /login');
        exit;
    }

    private function authenticate($email, $password, $error)
    {
        $user = (new User())->findByEmail($email);

        if ($user && password_verify($password, $user->password)) {
            return true;
        } else {
            $error = 'Correo electrónico o contraseña incorrectos.';
            return false;
        }
    }
}

