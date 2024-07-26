<?php

Use core\Model;

class User
{
    use Model;

    protected $table = 'users';
    protected $id = 'user_id';

    protected $fillable =
    [
        'name',
        'email',
        'password'
    ];

    protected $hidden =
    [
        'password',
        'remember_token',
    ];
};
