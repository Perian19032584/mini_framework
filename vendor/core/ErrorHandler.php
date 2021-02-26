<?php

namespace vendor\core;

class ErrorHandler {

    public function __construct(){
        if(DEBUG == 1){
            error_reporting(-1);
        }else{
            error_reporting(0);
        }
        set_error_handler([$this, 'errorHandler2']);//Тут this текущий класс, 2 параметр наш метод обработки ошибок
        //Главное не возвращать false в нашем методе иначе контроль обработки ошибок перейдет в пхп
        //Не берет фатальные ошибки

        ob_start();//Чтобы не показывать ошибку, от php
        register_shutdown_function([$this, 'fatalErrorHandler']);//Регистрация для фатальных ошибок

        set_exception_handler([$this, 'exceptionErrorHandler']);//Регистрация исключений ошибок
    }

    public function errorHandler2($errno, $errstr, $errfile, $errline){//4 параметра которые идут по умолчанию при обработке ошибок
        $this->logError($errstr, $errfile, $errline);
        if(DEBUG == 1 || in_array($errno, [E_USER_ERROR, E_RECOVERABLE_ERROR])){
            $this->displayError($errno, $errstr, $errfile, $errline);
        }
        return true;
    }

    /**
     * Метод который просто подключает шаблон ошибки view
     */

    protected function displayError($errno, $errstr, $errfile, $errline, $response = 500){ //Отправка 500 код ответа (значит ошибка сервера)
        http_response_code($response);//Код ответа сервера
        //var_dump($response);
        if($response == 404){
            require WWW . '/errors/404.php';
            die;
        }

        if(DEBUG == 1){
            require WWW .'/errors/dev.php';
        }else{
            require WWW. '/errors/prod.php';
        }
        die;
    }

    public function exceptionErrorHandler($e){
        $code = $e->getCode() ?: 500;
        $this->logError($e->getMessage(), $e->getFile(), $e->getLine());
        $this->displayError('Исключение', $e->getMessage(), $e->getFile(), $e->getLine(), $code);
    }

    public function fatalErrorHandler(){ # Этот метод скопированый из офф сайта пхп, по обработке ошибок
        $error = error_get_last();//Получить последню ошибку в данном случает фатальную

        if(!empty($error) && $error['type'] & ( E_ERROR | E_PARSE | E_COMPILE_ERROR | E_CORE_ERROR)){
            ob_end_clean();//Буфером мы очистили изначальную фатальную обработку ошибок в php

            $this->logError($error['message'], $error['file'], $error['line']);
            $this->displayError($error['type'], $error['message'], $error['file'], $error['line']);
        }else{
            ob_end_flush();
        }
    }

    /***
     * Метод отправлящие данные в логи
     */

    protected function logError($message = "", $file = "", $line = ""){
        error_log("[". date('Y-m-d H:i:s') ."] Текст ошибки: {$message} | Файл: {$file} | Строка: {$line} \n=============================================\n", 3, ROOT . "/tmp/errors/errors.log");
    }

}