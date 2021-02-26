<?php

namespace vendor\core;

use mysql_xdevapi\Exception;

class Router{

    protected static $routes = [];
    protected static $route = [];


    public static function add($regexp, $route = []){
        self::$routes[$regexp] = $route;
    }


    public static function getRoutes(){
        return self::$routes;
    }

    public static function getRoute(){
        return self::$route;
    }

    /**
     * Трудная функция для понимание
     * В регулярках оно взяло url и приминило ругулярное выражение с имминованием
     * <controller> <action> - вот откуда оно
     */


    private static function matchRoute($url){//Отделяем массив, и регулярные выражение

        foreach(self::$routes as $pattern => $match){

            if(preg_match("#$pattern#", $url, $result)){//По регуляркам принимаем запрос, (только буквы)

                foreach($result as $key => $value){

                    if(is_string($key)){
                        self::$route[$key] = $value;
                    }
                }
                if(!isset(self::$route['action'])){
                    self::$route['action'] = 'index';
                }
                self::$route['controller'] = self::upperCamelCase(self::$route['controller']);
                return true;
            }
        }
        return false;
    }

    /**
     * Решил попробовать такую запись, описание при навидение на функцию
     * Ищем url в таблице маршрутов
     * @param string $url входящий URL
     * @return void
    */
    public static function dispatch($url){

        $url = self::removeQueryString($url);

        if(self::matchRoute($url)){

            $controller = "app\controllers\\" . self::$route['controller'] . "Controller";
            // Разница между index - это уже создание а там просто подключение

            if(class_exists($controller)){  //Вся магия:) Cоздание обьета по url - все просто
                $cobj = new $controller(self::$route);
                $action = self::lowerCamelCase(self::$route['action']) . "Action";

                if(method_exists($cobj, $action)){
                    $cobj->$action();/* Параметр для подключение к view */
                    $cobj->getView();
                }else{
                    throw new \Exception("Метод <b>$action</b> не найден", 404);
                }
            }else{
                throw new \Exception("Контроллер <b>$controller</b> не найден", 404);
            }
        }else{
            throw new \Exception("Страница не найдена", 404);
        }
    }

    /**
     * Изменяем контролер убираем (-) и делаем с большой буквы
     * @param $name - ожидает имя контроллера
     */

    private static function upperCamelCase($name){
        $name = str_replace('-', ' ', $name);
        $name = ucwords($name);
        $name = str_replace(' ', '', $name);
        return $name; // Можно было и в ряд но я пишу код для людей
    }

    /**
     * @param $name - принимает строку (название метода)
     *
     * Функция которая получает адекватный метод, c правильным регистром
     */

    private static function lowerCamelCase($name){
        return lcfirst(self::upperCamelCase($name));
    }

    /**
     * Функция отделяет get параметры
     *
     */


    protected static function removeQueryString($data){
        $exp = explode('?', $data);
        $url = strtolower($exp[0]);//Переобразование в нижний регистр
        $url = trim(urldecode($url), " \t\n\r\0\x0B/");//Это я не понял

        return $url;
    }
}