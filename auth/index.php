<!-- АВТОРИЗАЦИЯ -->



<link rel="stylesheet" href="../css/style.css">
<?php
// подключаемся(набор настроек) к БД с помощью $_SERVER['DOCUMENT_ROOT']. уневерсальные метод для поиска
include_once($_SERVER['DOCUMENT_ROOT'].'/config.php');
// автоподключение всех класов
include_once($_SERVER['DOCUMENT_ROOT'].'/system/classes/autoload.php');

include($_SERVER['DOCUMENT_ROOT'] . '/components/head_doctype.php');

require_once($_SERVER['DOCUMENT_ROOT'] . '/components/header/index.php');
?>



<div class="wrapper margin-80-auto flex-box text-align-center">
    <form class="form" action="../system/controllers/users/auth.php" method="GET">
        <div>
            <input required type="text" name="login" placeholder="Логин или E-mail">
        </div>
        <div>
            <input required type="password" name="password" placeholder="Пароль">
        </div>

        <?php if (isset($_GET['wrong1'])): ?>
            <div class="padding-5 text-red">
                Неверный логин или пароль
            </div>
        <?php endif; ?>
        
        <div class="padding-10">
            <button class="btn-10-30-orange">Войти</button>
        </div>
        <p class="margin-0 text-14px">или</p>
        <div class="padding-5 nav text-orange-important">
            <a href="reg/index.php">зарегистрироваться</a>
        </div>
    </form>
</div>

<?php

include($_SERVER['DOCUMENT_ROOT'] . '/components/footer/index.php');

?>