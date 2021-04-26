<?php

  // подключаемся(набор настроек) к БД с помощью $_SERVER['DOCUMENT_ROOT']. уневерсальные метод для поиска
  include_once($_SERVER['DOCUMENT_ROOT'].'/config.php');
  // автоподключение всех класов
  include_once($_SERVER['DOCUMENT_ROOT'].'/system/classes/autoload.php');

// получение данных из формы
$login = $_GET['login'];
$password = $_GET['password'];

// подключение к БД и записываем
$connect = new Connect();

// проверка правельный ли логин и пароль
$result = mysqli_query($connect->getConnection(), "SELECT * FROM core_users WHERE login='$login' OR email='$login' ");
$user = mysqli_fetch_assoc($result);

if ($user['id']) {
    // начинаем проверку пароля т.к. юзер есть с таким логином есть
    // проверяем пароль  шифр crypt($password, $user['password'])
    if (hash_equals($user['password'],crypt($password,$user['password']))) {
        // echo"Вы успешно авторизовались".$user['login'];
        // куку 'user_id' -название $user['id']-значение time()+3600 - срок годности 1час от текущего времени '/'-видна везде
        setcookie('user_id', $user['id'], time() +3600, '/');
        header('location: http://mikhit.beget.tech/catalog.php');// редерект в каталог
    } else {
        header('location: http://mikhit.beget.tech/auth/index.php' . '?wrong1=1');// редерект если неверный пароль или логин c гет параметром
    }
} else {
    header('location: http://mikhit.beget.tech/auth/index.php' . '?wrong1=1'); // редерект если неверный пароль или логин c гет параметром
    
}


?>
