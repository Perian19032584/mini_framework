<?php


namespace vendor\core;



class Registry { //Класс для автоподключение файлов из конфига

    public static $objects = [];

    protected static $instance;

    protected static $properties = [];//Язык

    /**
     * Проходит по настрокам и создает обьект в статическую массив
     */

    protected function __construct(){
        $config = require ROOT . "/config/config.php";

        foreach ($config['components'] as $name => $component){
            self::$objects[$name] = new $component;
        }
    }

    public static function instance(){
        if(self::$instance === null){
            self::$instance = new self;
        }
        return self::$instance;
    }


    /**
     *  Вызивается автоматом при обращении к неизвесному свойству
     *  В нашем случае мы пишем ключ по которму вы обращаемся к классу
     *
     * Логика я пишу не известное свойство оно вовзращает обьект
     */
    public function __get($name){
        if(is_object(self::$objects[$name])){
            return self::$objects[$name];
        }
    }

    public function __set($name, $value){
        if(!isset(self::$objects[$name])){
            self::$objects[$name] = new $value;
        }
    }

    /**
     * Показ данных для тестов какие обьекты есть
     */

    public function getList(){
        echo "<pre>";
        var_dump(self::$objects);
        echo "</pre>";
    }

    /**
     * Ложим свои данные в массив, изначально мы ложим из контроллера AppController
     */

    public function setProperty($name, $value){
        self::$properties[$name] = $value;
    }

    /**
     *  Если есть массив получаем по ключу,
     *  По сути получаем весь массив кроме ключа lang - от изначального
     */

    public function getProperty($name){
        if(isset(self::$properties[$name])){
            return self::$properties[$name];
        }
        return null;
    }

    /**
     * Получить все настройки языка
     */

    public function getProperties(){
        return self::$properties;
    }
}