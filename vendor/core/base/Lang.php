<?php


namespace vendor\core\base;


class Lang {

    public static $lang_data = [];//Массив со всеми переводными фразами
    public static $lang_layout = [];
    public static $lang_view = [];

    /**
     * Принимает массив языка, и от роутов controller, view
     *
     */

    public static function load($code, $view){
        //var_dump($code['code']);
        //die;



        $lang_layout = APP . "/langs/{$code['code']}.php";
        $lang_view = APP . "/langs/{$code['code']}/{$view['controller']}/{$view['action']}.php";
        if(file_exists($lang_layout)){
            self::$lang_layout = require_once $lang_layout;
        }
        if(file_exists($lang_view)){
            self::$lang_view = require_once $lang_view;
        }
        self::$lang_data = array_merge(self::$lang_layout, self::$lang_view);//Сливаем массив в один

        //var_dump(self::$lang_data);
        //die;
    }

    public static function get($key){
        return self::$lang_data[$key];
    }
}