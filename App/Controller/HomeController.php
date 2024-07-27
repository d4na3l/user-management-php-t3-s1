<?php

namespace App\Controller;

class HomeController
{
    public function index()
    {
        $data = [
            'title' => 'Homepage',
        ];
        $viewController = new ViewController();
        $viewController->render('home', $data);
    }
}
