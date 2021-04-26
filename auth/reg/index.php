<!-- Регистрация -->


<?php
// подключаемся(набор настроек) к БД с помощью $_SERVER['DOCUMENT_ROOT']. уневерсальные метод для поиска
include_once($_SERVER['DOCUMENT_ROOT'].'/config.php');
// автоподключение всех класов
include_once($_SERVER['DOCUMENT_ROOT'].'/system/classes/autoload.php');

include($_SERVER['DOCUMENT_ROOT'] . '/components/head_doctype.php');

require_once($_SERVER['DOCUMENT_ROOT'] . '/components/header/index.php');
?>

<link rel="stylesheet" href="../../css/style.css">

<div class="wrapper margin-50-auto flex-box text-align-center">
    <form class="form" action="../../system/controllers/users/reg.php" method="get">
        <div>
            <input required type="text" name="login" placeholder="Логин">
        </div>
        <div>
            <input required type="text" name="email" placeholder="E-mail">
        </div>
        <div>
            <input  required type="password" name="password" placeholder="Пароль">
        </div>

        <?php if (isset($_GET['wrong'])): ?>
            <div class="padding-5 text-red">
            Такой логин или email уже существует
            </div>
        <?php endif; ?>


        <div class="padding-10">
            <button class="btn-10-30-orange" >Зарегистрироваться</button>
        </div>
        <p class="margin-0 text-14px">или</p>
        <div class="padding-5 nav text-orange-important">
            <a href="../index.php">Войти</a>
        </div>
    </form>
</div>

<?php

include($_SERVER['DOCUMENT_ROOT'] . '/components/footer/index.php');

?>