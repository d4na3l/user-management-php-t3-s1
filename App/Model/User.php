<?php

namespace App\Model;

use core\Model;

class User
{
    use Model;

    protected $table = 'users';
    protected $id = 'id';

    protected $fillable = [
        'name',
        'email',
        'password'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function save()
    {
        return $this->insert([
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password,
        ]);
    }

    public function findByEmail($email)
    {
        return $this->first(['email' => $email]);
    }
}
