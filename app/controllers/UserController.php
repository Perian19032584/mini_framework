<?php

namespace app\controllers;

use app\models\User;
use vendor\core\base\View;

class UserController extends AppController {

    public function signupAction(){
        if(!empty($_POST)){
            $user = new User();
            //var_dump($user);//Как
            $data = $_POST;

            $user->load($data);

            if(!$user->validate($data)){
                $user->getErrors();// Теперь у нас в $_SESSION['error'] есть вивод ошибок небольшой html
                redirect();
            }

            $user->attributes['password'] = md5($user->attributes['password']);

            $user->checkUnique();
            //var_dump($user->checkUnique());
            if($user->checkUnique()){
                if($user->save('user')){
                $_SESSION['success'] = 'Вы успешно зарегестрировались';
                    redirect();
                }
            }else{
                $_SESSION['error'] = "Данный пользователь уже существует";
            }
        }
        View::setMeta('Регистрация');
    }

    public function loginAction(){
        if(!empty($_POST)){
            $user = new User();
            if($user->login()){//return $_SESSION['user']
                $_SESSION['success'] = 'Вы успешно авторизированые';
            }else{
                $_SESSION['error'] = 'Логин/Пароль не верно';
            }

        }
    }

    public function logoutAction(){
        if($_SESSION['user']){
            unset($_SESSION['user']);
            redirect();
        }
    }

}