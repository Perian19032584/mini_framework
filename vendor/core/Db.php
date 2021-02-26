<?php

namespace vendor\core;

use R;

class Db{

    protected $pdo;
    protected static $instance;

    public static $countSql = 0;
    public static $queries = [];
    /**
     * Подключение к конфигу бд
     * Создание экземпляра класса
     */
    protected function __construct(){
        $db = require ROOT . "/config/config_bd.php";
        require LIBS . "/rb.php";

        R::setup($db['dsn'], $db['user'], $db['pass']);
        R::freeze( true ); # Запретить изменение структуры таблицы
    }

    /**
     * Хитрость если нету $instance, создается экземпляер класса
     * Это называется сиглтон - стиль программирование
     */

    public static function instance(){
        if(self::$instance === null){
            self::$instance = new self;
        }
        return self::$instance;
    }

}