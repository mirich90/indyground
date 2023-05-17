<?php

namespace App\Models;

use App\Model;

class User extends Model
{
    const TABLE = 'users';

    // public $email;
    // public $name;

    public $attributes = [
        'login' => '',
        'password' => '',
        'email' => '',
        'name' => '',
        'username' => '',
        'role' => 'user',
        'city' => '',
    ];

    public $rules = [
        'required' => [
            // ['login'],
            ['password'],
            ['email'],
            // ['name']

        ],
        'email' => [
            ['email'],
        ],
        'lengthMin' => [
            ['password', 6],
        ],
    ];

    public $rulesLogin = [
        'required' => [
            ['email'],
            ['password']
        ]
    ];

    public function checkUnique()
    {
        $user = $this->find(['email'], [$this->attributes['email']], 'OR');
        if ($user) {
            // if ($user['login'] == $this->attributes['login']) {
            //     $this->errors_validation['unique'][] = "Логин {$this->attributes['login']} уже занят";
            // }
            if ($user['email'] == $this->attributes['email']) {
                $this->errors_validation['unique'][] = "email {$this->attributes['email']} уже занят";
            }
            return false;
        }
        return true;
    }

    public function login()
    {
        $email = !empty(trim($_POST['email'])) ? trim($_POST['email']) : null;
        $password = !empty(trim($_POST['password'])) ? trim($_POST['password']) : null;
        if ($email && $password) {
            $user = $this->find(['email'], [$this->attributes['email']]);
            if ($user) {
                if (password_verify($password, $user['password'])) {
                    foreach ($user as $key => $value) {
                        if ($key != 'password') $_SESSION['user'][$key] = $value;
                    }
                    return true;
                }
            }
        }
        return false;
    }
}
