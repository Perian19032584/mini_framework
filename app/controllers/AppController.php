<?php

namespace app\controllers;

use vendor\core\App;
use vendor\core\base\Controller;
use R;
use vendor\widgets\language\Language;

class AppController extends Controller{
    
    public $menu;
    public $meta = [];
    
    public function __construct($route) {
        parent::__construct($route);//Парент тут написаный чтобы ничего не стерло
        if($this->route['controller'] == 'Main' && $this->route['action'] == 'test'){ // Можно также вот так написать если надо отследить
            //echo '<h1>TEST</h1>';
        }
        new \app\models\Main;

        $this->menu = R::findAll('category');//Если нужно будет глобальные данные
        //var_dump(Language::getLanguages());


        ////////////////////////////////////////////////////////////////////////////////////////////


        App::$app->setProperty('langs', Language::getLanguages());//Добавили в массив языки
        App::$app->setProperty('lang', Language::getLanguage(App::$app->getProperty('langs')));//Язык по умолчанию, получаем весь ассоциативный массив без первого ключа langs
                                            //Идет отправка данных для проверки есть ли такой язык из бд в куках,  и записует их
    }
    
    protected function setMeta($title = '', $desc = '', $keywords = ''){
        $this->meta['title'] = $title;
        $this->meta['desc'] = $desc;
        $this->meta['keywords'] = $keywords;
    }
    
}
