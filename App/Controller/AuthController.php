<?php

namespace App\Controller;

use App\Model\User;

class AuthController
{

        // Muestra el formulario de inicio de sesión
    public function showLoginForm()
    {
        $viewController = new ViewController();
        $viewController->render('login', ['name' => 'login']);
    }

    public function login($params = [])
    {
        // Verifica si la solicitud es POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Obtiene los datos de inicio de sesión
            $username = $params['email'] ?? null;
            $password = $params['password'] ?? null;

            // Autenticar usuario
            if ($this->authenticate($username, $password)) {
                // Redirecciona al dashboard o a otra página protegida
                header("Location: /home");
                exit;
            } else {
                $this->showLoginForm();
            }
        } else {
            // Si no es una solicitud POST, muestra el formulario de inicio de sesión
            $viewController = new ViewController();
            $viewController->render('login', ['name' => 'login']);
        }
    }

    public function showRegisterForm()
    {
        $viewController = new ViewController();
        $viewController->render('register', ['name' => 'Registro de usuario']);
    }

    public function register($params = [])
    {
        // Verifica si la solicitud es POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Obtiene los datos de registro
            $username = $params['username'] ?? null;
            $password = $params['password'] ?? null;
            $email = $params['email'] ?? null;

            // Crea un nuevo usuario
            $user = new User();
            $user->username = $username;
            $user->password = password_hash($password, PASSWORD_BCRYPT);
            $user->email = $email;
            $user->save();

            // Redirecciona al formulario de inicio de sesión o a otra página
            header("Location: /login");
            exit;
        } else {
            // Si no es una solicitud POST, muestra el formulario de registro
            $viewController = new ViewController();
            $viewController->render('register', ['name' => 'Registro de usuario']);
        }
    }

    public function showForgotPasswordForm()
    {
        $viewController = new ViewController();
        $viewController->render('forgot-password', ['name' => 'Olvidé mi contraseña']);
    }

    public function sendResetLink($params = [])
    {
        $email = $params['email'] ?? null;

        if ($email) {
            // Verificar si el usuario existe en la base de datos
            $user = (new User())->first(['email' => $email]);

            if ($user) {
                // Generar un token único
                $token = bin2hex(random_bytes(16));

                // Guardar el token en la base de datos o en una tabla separada
                // También se puede enviar el token por correo electrónico al usuario
                // Aquí simplemente redirigiremos a la vista de reset password como demostración

                // Redirigir a la vista de reset password con el token
                header("Location: /reset-password?token=" . $token);
                exit;
            }
        }

        // Mostrar el formulario de solicitud de restablecimiento si el correo no es válido
        $viewController = new ViewController();
        $viewController->render('forgot-password', ['error' => 'Correo electrónico no válido']);
    }

    public function resetPassword($params = [])
    {
        $token = $params['token'] ?? null;
        $password = $params['password'] ?? null;
        $confirmPassword = $params['confirm_password'] ?? null;

        if ($token && $password && $password === $confirmPassword) {
            // Verificar el token y obtener el usuario asociado
            // Esto es un ejemplo, aquí deberías verificar el token con tu base de datos
            // y obtener el usuario correspondiente

            // Supongamos que el usuario fue encontrado
            $user = (new User())->first(['email' => 'usuario@example.com']); // Cambiar según la lógica real

            if ($user) {
                // Actualizar la contraseña del usuario
                $user->update($user->id, ['password' => password_hash($password, PASSWORD_BCRYPT)]);

                // Redirigir al login
                header("Location: /login");
                exit;
            }
        }

        // Si falla la validación, mostrar el formulario de restablecimiento con un error
        $viewController = new ViewController();
        $viewController->render('reset-password', ['error' => 'Token no válido o las contraseñas no coinciden']);
    }

    public function logout()
    {
        // Termina la sesión del usuario
        session_start();
        session_destroy();
        header("Location: /login");
        exit;
    }

    private function authenticate($username, $password)
    {
        // Busca el usuario en la base de datos
        $user = User::findByUsername($username);

        // Verifica la contraseña
        if ($user && password_verify($password, $user->password)) {
            // Inicia sesión
            $_SESSION['logged_in'] = true;
            $_SESSION['user_id'] = $user->id;
            return true;
        }

        return false;
    }
}
