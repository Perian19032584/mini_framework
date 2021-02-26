<?php


namespace vendor\widgets\language;


use vendor\core\App;

class Language {

    protected $tpl;
    protected $languages;

    protected $language;

    public function __construct() {
        $this->tpl = __DIR__ . "/lang_tpl.php";//Текущая папка где вызывается __DIR__
        $this->run();
    }

    protected function run(){

        //По ключам получаем массив
        $this->languages = App::$app->getProperty('langs');
        $this->language = App::$app->getProperty('lang');


        echo $this->getHtml();//Получаем буфер шаблон
    }

    /**
     *  Данный метод возвращает массив со всеми языками
     */

    public static function getLanguages(){ // Всегда дает нам где base = 1
        return \R::getAssoc("SELECT code, title, base FROM language ORDER BY base DESC");//Для получение ассоциативного массива
    }

    /**
    * Метод берет базовый язык если в куках пусто
     */

    public static function getLanguage($languages){
        //var_dump(array_key_exists($_COOKIE['lang'], $languages));// Возвращает true или false - идет поиск по ключу
        if(isset($_COOKIE['lang']) && array_key_exists($_COOKIE['lang'], $languages)){//Проверка также на существование ключа языка, приходит из базы данных
            $key = $_COOKIE['lang'];
        }else{
            $key = key($languages);//Получаем первый включ, первого значение
        }
        $lang = $languages[$key];
        $lang['code'] = $key;//На всякий случай, добавили поле code и значение ключа code
        return $lang;
    }

    protected function getHtml(){
        ob_start();
            require_once $this->tpl;
        return ob_get_clean();
    }
}