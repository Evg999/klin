<?php


// var_dump($_FILES);

$id = (int)$_POST['id'];

  // подключаемся(набор настроек) к БД с помощью $_SERVER['DOCUMENT_ROOT']. уневерсальные метод для поиска
  include_once($_SERVER['DOCUMENT_ROOT'].'/config.php');
  // автоподключение всех класов
  include_once($_SERVER['DOCUMENT_ROOT'].'/system/classes/autoload.php');


//автоматическое получение данных из полей формы 
//подготовка массивов полей и значений
$arr_fields = [];
$arr_values = [];

//разбор всех пришедших данных и выкидываем id если ключ не равен
foreach ($_POST as $key => $value) {
    if ($key != 'id') {
        $arr_fields[] = $key;
        $arr_values[] = "'" .$value. "'";
    }
}

//проверка если массив пустой (например нет имени), то отправлять ничего не нужно
if ($_FILES['photo']['name']) {
    //создание уникального имени файла (чтобы не перезаписывать при совпадении имен)
    //разделение строки (имени файла) на части, точка - делитель
    $file_name_info = explode('.', $_FILES['photo']['name']);
    //запись левой части от точки в переменную (имя файла) - исходное название файла
    $file_pure_name = $file_name_info[0];
    //запись правой части от точки в переменную (расширение файла)
    $file_ext = $file_name_info[1];
    //уникальная сгенерированная строка
    $hash = md5($file_pure_name . time());
    //сборка нового уникального имени файла
    $file_new_name = $file_pure_name . '_' . $hash . '.' . $file_ext;

    //создание пути для записи файла
    $file_full_path = 'img/catalog/' . $file_new_name;

    //загрузка файла на сервер (сейчас локальный)
    move_uploaded_file($_FILES['photo']['tmp_name'], '../../../' . $file_full_path);  //'../../../' . $file_full_path --- относительный путь

    $arr_fields[] = 'photo';
    $arr_values[] = "'" . $file_full_path . "'"; 
}

$str_update = '';

for ($i = 0; $i < count($arr_fields); $i++) {
    $str_update = $str_update . $arr_fields[$i] . '=' . $arr_values[$i] . ',';
}
// trim обрезаем запетые
$str_update = trim($str_update, ',');

//подключаемся к БД и изменяем запрос для 
//подключение файла
$connect = new Connect();

// echo "UPDATE core_goods SET $str_update WHERE id=$id  ";

$result = mysqli_query($connect->getConnection(), "UPDATE core_goods SET $str_update WHERE id=$id "); //при автоматическом получении данных полей формы

if ($result) {
    // SERVER'HTTP_REFERER' предыдущая страница с который мы пришли
    header('Location: ' . $_SERVER['HTTP_REFERER']);
} else {
    echo 'что то пошло не так';
}

?>