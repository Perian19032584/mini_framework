<?php

namespace vendor\core\base;


use Valitron\Validator;
use vendor\core\Db;

abstract class Model{

    protected $pdo;
    protected $table;
    protected $pk = 'id';
    public $attributes = [];//Изначальное этот тег пустой - а показывает из модели User(load)

    public $errors = [];
    public $rules = [];

    public function __construct(){
        $this->pdo = Db::instance();//А также создает экземпляр класса
    }

    /**
     * Запрос без ответа кроме (true, false)
     */

    public function query($sql){
        return $this->pdo->execute2($sql);
    }
    /**
     * Возврат всех данных
     */
    public function findAll(){
        $sql = "SELECT * FROM {$this->table}";
        return $this->pdo->query($sql);
    }
    /**
     * Получение 1 записи бд
     * 2 параметра ('id', 'Поле поиска по умолчанию id')
     */
    public function findOne($id, $field = ''){
        $field = $field ?: $this->pk;
        $sql = "SELECT * FROM {$this->table} WHERE $field = ? LIMIT 1";
        return $this->pdo->query($sql, [$id]);//Подготовленый запрос для безопасности параметр
    }

    public function findBySql($sql, $params = []){
        //dd($params);
        return $this->pdo->query($sql, [$params]);
    }

    /**
     * Самый обычный like запрос
     * Первый параметр будет (id) Второй поле ко котору ищем
     */

    public function findLike($str, $field, $table = ''){
        $table = $table ?: $this->table;
        $sql = "SELECT * FROM {$this->table} WHERE $field LIKE ?";
        return $this->pdo->query($sql, [ "%" . $str . "%" ]);
    }
    /**
     * Загрузка данных в свойтсво атрибуры
     */
    public function load($data){
        foreach ($this->attributes as $name => $val){//$_POST - Что принимает
            if(isset($data[$name])){
                $this->attributes[$name] = $data[$name];
            }
        }
        //var_dump($this->attributes);
    }

    /**
     * Нашо валидация, библиотека vlucas/valitron
     */

    public function validate($data){
        Validator::lang('ru');
        $v = new Validator($data);
        $v->rules($this->rules);//Правила
        if($v->validate()){
            return true;
        }else{
            $this->errors = $v->errors();//Выведет ошибку
            return false;
        }
    }

    /**
     * Красивый вывод ошибок при срабатывании валидации
    */

    public function getErrors(){
        $errors = "<ul>";

        foreach ($this->errors as $error2){
            foreach ($error2 as $item){
                $errors .= "<li>$item</li>";
            }
        }
        $errors .= "<ul>";

        $_SESSION['error'] = $errors;//Закинул в сессию чтобы много раз не обьявлять
    }

    public function save($table){
        $tbl = \R::dispense($table);
        foreach ($this->attributes as $key => $attribute){
            $tbl->$key = $attribute;
        }
        return \R::store($tbl);
    }
}