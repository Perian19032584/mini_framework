<?php

namespace vendor\core\base;

use vendor\core\App;

class View{

    public $route = [];
    public $view;// текущий вид
    public $layout;// текущий шаблон

    public static $meta = ['title' => '', 'desc' => '', 'keywords' => ''];


    function __construct($route, $layout = '', $view = ''){
        $this->route = $route;
        if($layout === false){//Для строгой типизации, короче если чел хочет без шаблона
            $this->layout = false;
        }else{
            $this->layout = $layout ?: LAYOUT;
        }
        $this->view = $view;
    }

    /**
     * Подгружает шаблон и view
     *
     * view делает буфиризацию типо кэш
     */

    public function render($vars){

        Lang::load(App::$app->getProperty('lang'), $this->route);

        if(is_array($vars)){
            extract($vars);//Извличение из массива данных(ключ(становится переменой) значение становится значением текущей переменной)
        }


        $file_view = APP . '/views/'.$this->route['controller'] . "/" . $this->view . ".php";

        ob_start();//Буфиризация, первый раз слышу - не выводит на екран

        if(is_file($file_view)){
            require $file_view;
        }else{
            echo "<p>Не найден вид: $this->view </p>";
        }
        //Буфер этот как кэш шаблона для быстрой прогрузки
        $content = ob_get_clean();//Очистка буфер обмена и складывает в переменую content( все данные )

        if($this->layout !== false) { // Отключить шаблон
            $file_layout = APP . "/views/layouts/{$this->layout}.php";
            if (is_file($file_layout)) {
                require $file_layout;
            } else {
                echo "<p>Не найден шаблон: $this->layout </p>";
            }
        }
    }

    public static function getMeta(){
        echo "<title>" .  self::$meta['title']  . "</title>";
        echo "<meta name='description' content='".self::$meta['desc']."'>";
        echo "<meta name='keywords' content='".self::$meta['keywords']."'>";
    }
    public static function setMeta($title = "", $desc = "", $keywords = ""){
        self::$meta['title'] = $title;
        self::$meta['desc'] = $desc;
        self::$meta['keywords'] = $keywords;
    }
}