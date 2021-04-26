<?php

 // подключаемся(набор настроек) к БД с помощью $_SERVER['DOCUMENT_ROOT']. уневерсальные метод для поиска
 include_once($_SERVER['DOCUMENT_ROOT'].'/config.php');
 // автоподключение всех класов
 include_once($_SERVER['DOCUMENT_ROOT'].'/system/classes/autoload.php');

$email = $_POST['email'];

//подключаемся к БД и записываем
$connect = new Connect();

//проверка на наличие в БД таких логинов или паролей
$result = mysqli_query($connect->getConnection(), "SELECT COUNT(id) as num FROM mailings WHERE email='$email' ");
$info = mysqli_fetch_assoc($result);
$amount = $info['num'];

if (!empty($_POST['email'])) {
    if ($amount > 0) {
        //редирект
        header('location: http://mikhit.beget.tech/index.php' . '?inDatabase');
    } else {
        //создаем новую строчку в таблице
        mysqli_query($connect->getConnection(), "INSERT INTO mailings(email) VALUES('$email') ");
        header('location: http://mikhit.beget.tech/index.php' . '?success=1');
    }
} else {
    //редирект
    header('location: http://mikhit.beget.tech/index.php' . '?wrong=1');
}

?>