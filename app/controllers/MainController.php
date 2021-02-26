<?php

namespace app\controllers;

use app\models\Main;
use R;
use vendor\core\App;
use vendor\core\base\View;
use vendor\widgets\language\Language;

class MainController extends AppController{
    
//    public $layout = 'main';
    
    public function indexAction(){
    var_dump();
        $lang = App::$app->getProperty('lang');
        $posts = R::findAll('posts', 'lang = ?', [$lang['code']]);//Мультиязычность бд


//        $posts = App::$app->cache->get('posts');
//        if(!$posts){
//            $posts = R::findAll('posts');
//            App::$app->cache->set('posts', $posts);
//        }


        $post = R::findOne('posts', 'id = 1');
        $menu = $this->menu;
        $title = 'PAGE TITLE';
        View::setMeta('Название страницы', 'Описание страницы', 'Ключивые слова');
        $meta = $this->meta;
        $this->set(compact('title', 'posts', 'menu', 'meta'));
    }
    
    public function testAction(){
        if($this->isAjax()){
            $this->layout = false;
            $posts = R::findOne('posts', 'id = ' . $_POST['id']);

            $this->loadView('ajax', compact('posts'));
        }

    }
    
}
