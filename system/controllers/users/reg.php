<?php

  // подключаемся(набор настроек) к БД с помощью $_SERVER['DOCUMENT_ROOT']. уневерсальные метод для поиска
  include_once($_SERVER['DOCUMENT_ROOT'].'/config.php');
  // автоподключение всех класов
  include_once($_SERVER['DOCUMENT_ROOT'].'/system/classes/autoload.php');

// получение данных из формы
$login = $_GET['login'];
$email = $_GET['email'];
// шифрует $password = crypt($_GET['password']);
$password = crypt($_GET['password']);

// подключение к БД и записываем
$connect = new Connect();

// проверка есть ли юзер или пароль в базе данны для регестрации, подсчитываем и записываем в переменную из КОР ЮЗЕР где логин или емаил
$result = mysqli_query($connect->getConnection(), "SELECT COUNT(id) as num FROM core_users WHERE login='$login' OR email='$email' ");
// получаем ответ
$info = mysqli_fetch_assoc($result);
// записываем в переменную
$amount = $info['num'];
// если больше нуля не записываем если 
if ($amount > 0) {
    header('location: http://mikhit.beget.tech/auth/reg/index.php' . '?wrong=1');
    
} else {
    // делаем запрос к БД \(COUNT)- посчитать кол-во (id) и положить их в переменную NUM
    // СОЗДАЁМ НОВУЮ СТРОЧКУ В ТАБЛИЧКЕ
    mysqli_query($connect->getConnection(), "INSERT INTO core_users(login, email, password) VALUES('$login', '$email', '$password') ");
    header('location: http://mikhit.beget.tech/auth/index.php');

}

?>
