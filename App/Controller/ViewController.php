<?php

namespace App\Controller;

class ViewController
{

    protected $guestViews = [
        'login',
        'register',
        'forgot-password',
        'reset-password'
    ];

    public function render($view, $data = [])
    {
        // Determinar si la vista solicitada es accesible para invitados
        if (!$this->isAuthenticated() && !in_array($view, $this->guestViews)) {
            $this->redirectToLogin();
        }


        // Determinar el layout adecuado
        $layout = $this->getLayout();

        // Verificar si la vista existe y preparar el archivo de vista
        $viewFile = $this->getViewFile($view);

        // Preparar los datos para el layout
        $data['view'] = $viewFile;

        // Renderizar el layout con la vista y los datos
        require $this->getLayoutFile($layout);
    }

    protected function getLayout()
    {
        return $this->isAuthenticated() ? 'app' : 'guest';
    }

    protected function getViewFile($view)
    {
        $viewFile = "../resources/views/{$view}.view.php";

        // Si la vista no existe, usar 404
        if (!file_exists($viewFile)) {
            return "../resources/views/layouts/404.view.php";
        }

        return $viewFile;
    }

    protected function getLayoutFile($layout)
    {
        return "../resources/views/layouts/{$layout}.view.php";
    }

    protected function isAuthenticated()
    {
        return isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
    }

    protected function onlyPermission($view)
    {
        $protectedViews = [
            'home', 'profile', 'dashboard', // Agrega aquí las vistas protegidas
        ];

        return in_array($view, $protectedViews);
    }

    public static function redirectToLogin()
    {
        header('Location: /login');
        exit();
    }

}
