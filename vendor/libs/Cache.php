<?php

namespace vendor\libs;

class Cache {

    public function __construct(){

    }

    /***
     * Ложит кэш по папкам
     */

    public function set($key, $data, $seconds = 3600){
        $content['data'] = $data;
        $content['end_time'] = time() + $seconds;//Данные кешируются ровно на 1 час


        if(file_put_contents(CACHE . "/" . md5($key) . ".txt", serialize($content))){ //serialize - Для хранение данных
            return true;
        }
        return false;
    }
    /**
     * Считывает данные
     */
    public function get($key){
        $file = CACHE . "/" . md5($key) . ".txt";
        if(file_exists($file)){
            $content = unserialize(file_get_contents($file));//Вот так мы считывает данные
            if(time() <= $content['end_time']){//Проверка на актальность не прошло ли время
                return $content['data'];
            }
            unlink($file);//Удаляем файл
        }
        return false;
    }

    public function delete($key){
        $file = CACHE . "/" . md5($key) . ".txt";
        if(file_exists($file)){
            unlink($file);//Удаляем файл
        }
    }
}