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
            'password' => password_hash($this->password, PASSWORD_DEFAULT), // Asegúrate de hashear la contraseña
        ]);
    }

    public function findByEmail($email)
    {
        return $this->first(['email' => $email]);
    }

    public function findById($id)
    {
        return $this->first(['id' => $id]);
    }

    public function allExceptLoggedIn($loggedInUserId)
    {
        $result = $this->where([], ['id' => $loggedInUserId]);
        return $result ?: [];
    }
}
