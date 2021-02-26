<?php

namespace app\controllers;

/**
 * Description of Main
 *
 */
class PostsController extends AppController{
    
    public function indexAction(){
        echo 'Main::index';
    }
    
    public function testAction(){
        debug($this->route);
        echo 'Main::test';
    }
    
}
