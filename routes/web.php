<?php

return [
    'GET' => [
        '/' => 'HomeController@index',
        '/home' => 'HomeController@index',
        '/login' => 'AuthController@showLoginForm',
        '/register' => 'AuthController@showRegisterForm',
        '/forgot-password' => 'AuthController@showForgotPasswordForm',
        '/reset-password' => 'AuthController@showResetPasswordForm',
        '/profile' => 'ProfileController@show',
    ],
    'POST' => [
        '/login' => 'AuthController@login',
        '/register' => 'AuthController@register',
        '/logout' => 'AuthController@logout',
        '/forgot-password' => 'AuthController@sendResetLink',
        '/reset-password' => 'AuthController@resetPassword',
        '/profile/updateName' => 'ProfileController@updateName',
        '/profile/updateEmail' => 'ProfileController@updateEmail',
        '/profile/updatePassword' => 'ProfileController@updatePassword',
        '/profile/delete' => 'ProfileController@delete',
    ],
];
