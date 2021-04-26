<?php


// подключаемся(набор настроек) к БД с помощью $_SERVER['DOCUMENT_ROOT']. уневерсальные метод для поиска
include_once($_SERVER['DOCUMENT_ROOT'].'/config.php');
// автоподключение всех класов
include_once($_SERVER['DOCUMENT_ROOT'].'/system/classes/autoload.php');
//автоматическое получение данных из полей формы 
//подготовка массивов полей и значений
$arr_fields = [];
$arr_values = [];

//разбор всех пришедших данных
foreach ($_POST as $key => $value) {
    $arr_fields[] = $key;
    $arr_values[] = "'". $value ."'";
}


// ЕСЛИ имя одинаковое при закачки  как их передалать что бы не перезатёрлись

//создание уникального имени файла (чтобы не перезаписывать при совпадении имен)
//разделение строки (имени файла) на части, точка - делитель
$file_name_info = explode('.', $_FILES['photo']['name']);
//запись левой части от точки в переменную (имя файла) - исходное название файла ТОЛЬКО ИМЯ
$file_pure_name = $file_name_info[0];
//запись правой части от точки в переменную (расширение файла) РАСШИРЕНИЙ
$file_ext = $file_name_info[1];
//уникальная сгенерированная строка ХЭШЕМ
$hash = md5($file_pure_name . time());
//сборка нового уникального имени файла
$file_new_name = $file_pure_name . '_' . $hash . '.' . $file_ext;

//создание пути для записи файла в бд
$file_full_path = 'img/catalog/' . $file_new_name;


//загрузка файла на сервер (сейчас локальный)
move_uploaded_file($_FILES['photo']['tmp_name'], '../../../'.$file_full_path);  //'../../../' . $file_full_path --- относительный путь

$arr_fields[] = 'photo';
$arr_values[] = "'" . $file_full_path . "'"; 

//преобразование массивов к строкам для подстановки в запрос
$str_fields = implode(',', $arr_fields); //сборка строки через запятую из массива
$str_values = implode(',', $arr_values);




//подключаемся к БД и записываем
//подключение файла
$connect = new Connect();

// echo "INSERT INTO core_goods($str_fields) VALUES($str_values)";

$result = mysqli_query($connect->getConnection(), "INSERT INTO core_goods($str_fields) VALUES($str_values) ");

if ($result) {
    //echo 'Товар создан'
    header('Location: http://mikhit.beget.tech/admin/?page=items');
} else {
    echo 'что то пошло не так, поля: Название товара, Артикул, Цена - обязательны для заполнения';
}

?>
