<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <? \vendor\core\base\View::getMeta()?>

        <link href="/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="/css/main.css" rel="stylesheet">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    </head>
    <body>
    <center>
        <br>
        <a href="/user/signup"><h3 class="d-inline">Регистрация</h3></a> |||||| <a href="/user/login"><h3 class="d-inline">Авторизация</h3></a>
    </center>

    <? __('default')?>
    <? __('categories')?>
    <? __('test')?>
    <? __('test2')?>


    <? new \vendor\widgets\language\Language()?>


    <? if($_SESSION['error']) :?>
        <div class="alert alert-danger">
            <?= $_SESSION['error'] ?>
        </div>
    <? endif?>


    <? if($_SESSION['success']) :?>

        <div class="alert alert-success">
            <?= $_SESSION['success']?>
        </div>

    <? endif?>


    <hr>
        <div class="container">
            <?php if(!empty($menu)): ?>
            <ul class="nav nav-pills">
                <li><a href="page/about">About</a></li>
            <?php foreach ($menu as $item): ?>  
                <li><a href="category/<?= $item['id'] ?>"><?= $item['title'] ?></a></li>
            <?php endforeach; ?>
            </ul>
            <?php endif; ?>


            <?= $content ?>


        </div>

        <? if($_SESSION['user']){
            echo "<a href='/user/logout'><h6>Выйти</h6></a>";
        }?>




        <script src="/bootstrap/js/bootstrap.min.js"></script>

    </body>
</html>