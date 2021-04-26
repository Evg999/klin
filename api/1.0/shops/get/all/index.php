<?php

// делаем API для about

// подключаемся(набор настроек) к БД с помощью $_SERVER['DOCUMENT_ROOT']. уневерсальные метод для поиска
include_once($_SERVER['DOCUMENT_ROOT'].'/config.php');
// автоподключение всех класов
include_once($_SERVER['DOCUMENT_ROOT'].'/system/classes/autoload.php');


// подключаемся к БД

$connect = new Connect(); 
//запрос к DB
$result = mysqli_query($connect->getConnection(), "SELECT * FROM core_shops" );

$arr = [];

//создание ассоциативного массива с данными из DB
while($info = mysqli_fetch_assoc($result)){
    //наполнение ассоциативного массива в ручную
    $arr_item = [];
    $arr_item['title'] = $info['title'];
    $arr_item['description'] = $info['description'];
    $arr_item['photo'] = $info['photo'];
    $arr_item['address'] = $info['address'];
    $arr_item['latitude'] = $info['latitude'];
    $arr_item['longitude'] = $info['longitude'];
    
    $arr[] = $arr_item;
}

//вывод на экран данных в формате json (json для дальнейшей обработки на JS) //называется REST API или JSON API
echo json_encode($arr);

?>