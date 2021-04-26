<?php

session_start();

$id = (int)$_POST['id'];

// подключаемся(набор настроек) к БД с помощью $_SERVER['DOCUMENT_ROOT']. уневерсальные метод для поиска
include_once($_SERVER['DOCUMENT_ROOT'].'/config.php');
// автоподключение всех класов
include_once($_SERVER['DOCUMENT_ROOT'].'/system/classes/autoload.php');

//подключаемся к БД
$connect = new Connect();

$result = mysqli_query($connect->getConnection(), "SELECT * FROM core_users WHERE id=$id ");
$user = mysqli_fetch_assoc($result);

//автоматическое получение данных из полей формы 
//подготовка массивов полей и значений
$arr_fields = [];
$arr_values = [];

//разбор всех пришедших данных
foreach ($_POST as $key => $value) {
/*
    //вариант Тимофея
    if ($key != 'id') {
        $arr_fields[] = $key;       
    
        if ($key == 'password' && $value != $user['password']) {
            $arr_values[] = "'" . crypt($value) . "'";
            //var_dump($arr_values);
        } else {
            $arr_values[] = "'" . $value . "'";
            //var_dump($arr_values);
        }
    } 
*/       
    //мой вариант
    if ($key != 'id') {
        $arr_fields[] = $key;
        $arr_values[] = "'" . $value . "'";  
        //var_dump($arr_values);
    } 
    if ($key == 'password' && $value != $user['password']) {
        $arr_values[count($arr_values)-1] = "'" . crypt($value) . "'";
        //var_dump($arr_values);
    }   
}

//сборка строки для подстановки в запрос
$str_update = '';

for ($i = 0; $i < count($arr_fields); $i++) {
    $str_update = $str_update . $arr_fields[$i] . '=' . $arr_values[$i] . ',';
}

$str_update = trim($str_update, ',');

//подключаемся к БД и изменяем запрос для 
//подключение файла
$connect = new Connect();

// echo "UPDATE core_users SET $str_update WHERE id=$id  ";

$result = mysqli_query($connect->getConnection(), "UPDATE core_users SET $str_update WHERE id=$id "); //при автоматическом получении данных полей формы

if ($result) {
    header('Location: ' . $_SERVER['HTTP_REFERER']);
} else {
    echo 'что то пошло не так';
}

?>