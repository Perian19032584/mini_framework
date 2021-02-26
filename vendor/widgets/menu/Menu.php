<?php

namespace vendor\widgets\menu;

use R;

class Menu {

    protected $data;
    protected $tree;
    protected $menuHtml;
    protected $tpl = __DIR__ . "/menu_tpl/menu.php";
    protected $table = 'categories';


    public function __construct(){
        $this->run();
    }

    /**
     * Запуск всех методов
    */
    protected function run(){
        $this->data = R::getAssoc("SELECT * FROM ". $this->table);//Чтобы получить только массив не обьект, первым параметром делает ключ
        $this->tree = $this->getTree();
        $this->menuHtml = $this->getMenuHtml($this->tree);
        echo $this->menuHtml;
    }

    /**
     *  По цыклу создается дерево
     *  Надо будет разобрать
     */

    protected function getTree(){
        $tree = [];
        $data = $this->data;

        foreach ($data as $id => &$node){//Что такое &
            if(!$node['parent']){
                $tree[$id] = &$node;
            }else{
                $data[$node['parent']]['shilds'][$id] = &$node;
            }
        }

        return $tree;
    }


    protected function getMenuHtml($tree, $tab = ''){//Передать сюда дерево
        $str = '';
        foreach ($tree as $id => $category){
            $str .= $this->catToTemplate($category, $tab, $id);//Поставил точку чтобы не затералось,
        }
        return $str;
    }
    protected function catToTemplate($category, $tab, $id){
        ob_start();//Буфиразация не выводит на экран, а просто типо закидует в переменную
            require $this->tpl;
        return ob_get_clean();
    }
}