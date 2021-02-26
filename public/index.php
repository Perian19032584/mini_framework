<?php


use vendor\core\Router;

$query = rtrim(substr($_SERVER['REQUEST_URI'], 1), '/');//Обрезка с двух сторон


define('DEBUG', 0);//1 - режим разработки | 0 - хостинг

define('WWW', __DIR__);//В public, текущая папка где вызывается код __DIR__
define('CORE', dirname(__DIR__) . "/vendor/core");
define("ROOT", dirname(__DIR__));
define("APP", dirname(__DIR__) . "/app");
define('LAYOUT', 'default');
define('LIBS', dirname(__DIR__) . "/vendor/libs");
define('CACHE', dirname(__DIR__) . "/tmp/cache");



spl_autoload_register(function ($class){
    $file = ROOT . "/" . str_replace('\\', '/', $class . ".php");//Таким простым образом получаем полный путь к нейспесам(классам)
    if(is_file($file)){
        require_once $file;
    }
});


require "../vendor/vlucas/valitron/src/Valitron/Validator.php";
require "../vendor/libs/functions.php";


$app = new \vendor\core\App();



Router::add('^(?P<controller>[a-z-]+)/?(?P<action>[a-z-]+)?$');//Обернул в ?(бла бла)? - это значит не обязательно

Router::dispatch($query);
