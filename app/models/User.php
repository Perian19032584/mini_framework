<?php

namespace app\models;

use vendor\core\base\Model;
use R;
class User extends Model {

    public $attributes = [
        'password' => '',
        'email' => '',
        'name' => '',
    ];

    // Валидация - библиотека vlucas/valitron

    public $rules = [
        'required' => [
            ['password'],
            ['email'],
            ['name'],
        ],
        'email' => [
            ['email'],
        ],
        'lengthMin' => [
            ['password', 6],
        ]
    ];

    /**
     * Проверк на схожость с email
     */


    public function checkUnique(){
        $user = R::findOne('user', 'email = ? LIMIT 1', [$this->attributes['email']]);//Гребаный синтаксис этой чертовой библиотеки
        //var_dump($this->attributes['email']);

        if($user){

            $this->errors['unique'][] = 'Этот email уже занят';
            return false;
        }
        return true;
    }

    public function login(){
        $login = !empty(trim($_POST['email'])) ? trim($_POST['email']) : null;
        $password = !empty(trim($_POST['password'])) ? trim($_POST['password']) : null;
        if($login && $password){
            $users = R::findOne('user', 'email = ? OR password = ? LIMIT 1', [$login, md5($password)]);
            foreach($users as $key => $user){
                if($key != "password"){
                    $_SESSION['user'][$key] = $user;
                }
            }
            return true;
        }
        return false;
    }

}