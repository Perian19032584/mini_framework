<?php

namespace vendor\core\base;

abstract class Controller{

    public $route = [];
    public $view;
    public $layout;
    public $vars = [];//Пользовательские данные при передаче с контроллера
    public function __construct($data){
        $this->route = $data;
        $this->view = $data['action'];

    }
    /**
     * Создание экземпляра класса View
     * и вызов метода который подключается к шаблону и создает буфер view
     */
    public function getView(){

        $vObj = new View($this->route, $this->layout, $this->view);
        $vObj->render($this->vars);
    }

    /**
     * Пользовательские параметры

     */

    public function set($param){
        $this->vars = $param;
    }

    public function isAjax(){ // Скопированый из yii проверка на ajax
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';
    }

    /**
     * Передача вида view, и параметров которые должны быть массивом
     * И простое подключение к виду
     */

    public function loadView($view, $post = []){

        require APP . "/views/" . $this->route['controller'] . "/{$view}.php";
    }
}