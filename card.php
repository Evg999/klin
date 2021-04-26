<?php
// КАРТОЧКА
  // подключаемся(набор настроек) к БД с помощью $_SERVER['DOCUMENT_ROOT']. уневерсальные метод для поиска
  include_once($_SERVER['DOCUMENT_ROOT'].'/config.php');
  // автоподключение всех класов
  include_once($_SERVER['DOCUMENT_ROOT'].'/system/classes/autoload.php');

  include($_SERVER['DOCUMENT_ROOT'] . '/components/head_doctype.php');

  require_once($_SERVER['DOCUMENT_ROOT'] . '/components/header/index.php');


  $good = new Good($_GET['id']);
  

// узнаём категорию
        $category = new Category($good->getField('category_id'));// подключаем Category Класс  прокидываем ГЕТ
        $cat_name = $category->getField('title'); //и такоеже будем имя по тайтлу Мужчина Детям или Женщинам
// узнаём тип
        $type =  new Type($good->getField('type_id'));
        $type_name = $type->getField('title');
?>

<!-- ХЛЕБНЫЕ КРОШКИ -->
<div class="breadcrumbs wrapper nav padding-30 text-up text-12px">
    <a class="text-12" href="index.php">Главная</a> / <a href="catalog.php">Каталог</a> / <a href="catalog.php?category_id=<?= $good->getField('category_id') ?>"><?= $cat_name ?></a> / <a href="catalog.php?category_id=<?= $good->getField('category_id') ?> & type_id=<?= $good->getField('type_id') ?>"><?= $type_name ?></a> / <?= $good->title() ?>
</div>


<div class="flex-box margin-top-60">
    <div class="card item-photo-card">
        <img src="<?= $good->photo() ?>">
    </div>
</div>
<div class="wrapper-700 text-align-center">
    <div class="text-up">
        <h1 class="margin-0"><?= $good->title() ?></h1>            
    </div>
    <div class="text-gray">
        Артикул: <?= $good->getField('articul') ?>
    </div>
    <h2 class="text-i padding-10"><?= $good->price() ?> руб.</h2>
    <div class="padding-10">
        <?= $good->getField('description') ?>
    </div>
    <p class="text-up margin-top-30">Размер</p>
    <div class="square"></div>
    <!-- корзина,    реализуем кнопку получим айди запишим ID выбранного товара и отправляем его фаел(обработчик) который будет класть его в карзину-->
    <!-- onclick = "toBasket()" вешиваем -->
    <div onclick="toBasket()" class="margin-40 btn-10-30-orange">добавить в корзину</div>
</div> 
</div> 



<?php

include($_SERVER['DOCUMENT_ROOT'] . '/components/footer/index.php');

?>


 