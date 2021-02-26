<?php

use vendor\core\base\Lang;

function dd($arr){
    echo "<pre>".print_r($arr, true)."</pre>";
}


function redirect($http = false){//Самое обычное перенаправление
    if($http){
        $redirect = $http;
    }else{
        $redirect = isset($_SESSION['HTTP_REFERER']) ? $_SESSION['HTTP_REFERER'] : '/main';
    }
    header("Location: $redirect");
}


function __($key){//Так принятно в фреймворках называть язык ключ
    echo Lang::get($key);
}