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
        $viewFile = $this->getViewFile($view);

        if (!$viewFile || $view === '404') {
            $viewFile = $this->getViewFile('layouts/404');
            $data['view'] = $viewFile;
            require $viewFile;
            return;
        }

        if ($this->isAuthenticated() && in_array($view, $this->guestViews)) {
            $this->redirectToHome();
        }

        if (!$this->isAuthenticated() && !in_array($view, $this->guestViews)) {
            $this->redirectToLogin();
        }

        $layout = $this->getLayout();

        $data['view'] = $viewFile;
        $data['csrf_token'] = $_SESSION['csrf_token'] ?? '';
        if ($this->isAuthenticated() && !isset($data['profileUser'])) {
            $data['user'] = $_SESSION['user'];
        }

        require $this->getLayoutFile($layout);
    }

    protected function getLayout()
    {
        return $this->isAuthenticated() ? 'app' : 'guest';
    }

    protected function getViewFile($view)
    {
        $viewFile = "../resources/views/{$view}.view.php";

        if (!file_exists($viewFile)) {
            return null;
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
            '/', 'home', 'profile',
        ];

        return in_array($view, $protectedViews);
    }

    public static function redirectToLogin()
    {
        header('Location: /login');
        exit();
    }

    public static function redirectToHome()
    {
        header('Location: /home');
        exit();
    }
}
