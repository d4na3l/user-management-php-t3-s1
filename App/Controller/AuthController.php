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
        session_start();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? null;
            $password = $_POST['password'] ?? null;

            $error = '';
            if ($this->authenticate($email, $password, $error)) {
                $_SESSION['logged_in'] = true;
                $_SESSION['user'] = (new User())->findByEmail($email); // Guardar el usuario en la sesión
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
        session_start();

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
        session_start();

        $email = $_POST['email'] ?? null;

        if ($email) {
            $user = (new User())->first(['email' => $email]);

            if ($user) {
                $token = bin2hex(random_bytes(16));
                // Aquí se enviaría el correo electrónico con el token

                $viewController = new ViewController();
                $viewController->render('forgot-password', ['name' => 'Olvidé mi contraseña', 'message' => 'Enlace de restablecimiento enviado', 'token' => $token]);
                return;
            }
        }

        $viewController = new ViewController();
        $viewController->render('forgot-password', ['name' => 'Olvidé mi contraseña', 'error' => 'Correo electrónico no válido']);
    }

    public function showResetPasswordForm()
    {
        $viewController = new ViewController();
        $viewController->render('reset-password', ['name' => 'Restablecer contraseña']);
    }

    public function resetPassword()
    {
        session_start();

        $token = $_POST['token'] ?? null;
        $password = $_POST['password'] ?? null;
        $confirmPassword = $_POST['confirm_password'] ?? null;

        if ($token && $password && $password === $confirmPassword) {
            $user = (new User())->first(['email' => 'usuario@example.com']); // Cambiar según la lógica real

            if ($user) {
                $user->update($user->id, ['password' => password_hash($password, PASSWORD_BCRYPT)]);
                header('Location: /login');
                exit;
            }
        }

        $viewController = new ViewController();
        $viewController->render('reset-password', ['name' => 'Restablecer contraseña', 'error' => 'Token no válido o las contraseñas no coinciden']);
    }

    public function logout()
    {
        session_start();
        session_destroy();
        header('Location: /login');
        exit();
    }

    private function authenticate($email, $password, &$error)
    {
        $userModel = new User();
        $user = $userModel->findByEmail($email);

        if ($user && password_verify($password, $user->password)) {
            $_SESSION['user_id'] = $user->id;
            $_SESSION['logged_in'] = true;
            $_SESSION['user'] = $user; // Guardar el usuario en la sesión
            return true;
        } else {
            $error = $user ? 'Contraseña incorrecta.' : 'Usuario no registrado.';
            return false;
        }
    }
}
