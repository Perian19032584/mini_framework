<?php


namespace app\controllers;


use vendor\core\App;

class LanguageController extends AppController {

    public function changeAction(){//Ничего сложно по клику меняет куки если есть базе язык - база это ключ:)
        $lang = !empty($_GET['lang']) ? $_GET['lang'] : null;
        if($lang){
           if(array_key_exists($lang, App::$app->getProperty('langs'))){//Проверка на существование из бд | по ключу
                setcookie('lang', $lang, time() + 3600*24, '/');
           }
        }
        redirect();
        die;
    }

}