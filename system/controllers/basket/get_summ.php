<?php

session_start();

// подключаемся(набор настроек) к БД с помощью $_SERVER['DOCUMENT_ROOT']. уневерсальные метод для поиска
include_once($_SERVER['DOCUMENT_ROOT'].'/config.php');
// автоподключение всех класов
include_once($_SERVER['DOCUMENT_ROOT'].'/system/classes/autoload.php');

$summ = 0;

if (isset($_SESSION['basket'])) {
    foreach($_SESSION['basket'] as $id) {        
        $good = new Good($id);
        $summ += $good->price();
   }
   
    echo $summ;
}

?>