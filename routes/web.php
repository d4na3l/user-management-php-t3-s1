<?php

return [
    'GET' => [
        '/' => 'HomeController@index', // Ruta pública o protegida basada en lógica interna
        '/login' => 'AuthController@showLoginForm',
        '/register' => 'AuthController@showRegisterForm',
        '/forgot-password' => 'AuthController@showForgotPasswordForm',
        '/reset-password' => 'AuthController@showResetPasswordForm', // Vista de formulario de restablecimiento
        '/dashboard' => 'DashboardController@index', // Ruta protegida
        // Otras rutas GET
    ],
    'POST' => [
        '/login' => 'AuthController@login',
        '/register' => 'AuthController@register',
        '/logout' => 'AuthController@logout', // Ruta protegida
        '/forgot-password' => 'AuthController@sendResetLink', // Envía el enlace de restablecimiento
        '/reset-password' => 'AuthController@resetPassword', // Procesa el restablecimiento de contraseña
        // Otras rutas POST
    ],
];
