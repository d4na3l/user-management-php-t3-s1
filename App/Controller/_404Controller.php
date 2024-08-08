<?php

namespace App\Controller;

class _404Controller
{
    public function show($message)
    {
        $data = [
            'title' => '404 - Not Found',
            'message' => $message
        ];

        $viewController = new ViewController();
        $viewController->render('404', $data);
    }
}
