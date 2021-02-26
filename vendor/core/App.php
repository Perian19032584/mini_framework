<?php


namespace vendor\core;

use vendor\core\Registry;
use vendor\core\ErrorHandler;

class App {

    public static $app;

    public function __construct(){//Становится обьектом
        self::$app = Registry::instance();
        new ErrorHandler;
    }

}