<?php

use core\Model;

class User
{
    use Model;

    protected $table = 'users';
    protected $id = 'user_id';

    protected $fillable = [
        'name',
        'email',
        'password'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Método para guardar el usuario en la base de datos
    public function save()
    {
        return $this->insert([
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password,
        ]);
    }

    // Método para buscar un usuario por su correo electrónico
    public function findByEmail($email)
    {
        return $this->first(['email' => $email]);
    }
}
