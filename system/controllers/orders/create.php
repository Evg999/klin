<?php
session_start();

// получаем заказ В БД В АДМИН И ТЕЛЕГУ

  // подключаемся(набор настроек) к БД с помощью $_SERVER['DOCUMENT_ROOT']. уневерсальные метод для поиска
  include_once($_SERVER['DOCUMENT_ROOT'].'/config.php');
  // автоподключение всех класов
  include_once($_SERVER['DOCUMENT_ROOT'].'/system/classes/autoload.php');
  

// преобразуем и сделаем массив название полей и второй значение полей
$arr_fields= [];
$arr_values = [];

// разбиваем наш массив $_GET на ключ - значение
foreach($_GET as $key => $value){
    // наполняем в цикле автоматически и то что ниже становить автоматически и прописывать не нужно как ниже
    $arr_fields[] = $key;
    // конкатинируем ковычки для значений каждого поля, в итоге каждое значение будет в ковычках
    $arr_values[] = "'".$value."'";           
}

//  $first_name = $_GET['first_name'];
//  $email = $_GET['email'];
//  $phone = $_GET['phone'];

// $goods = json_encode($_SESSION['basket']);

// $publ_time = time();


// отдельные обработчик полей для добавления в массив
$arr_fields[] = 'goods';
$arr_values[] = "'" . json_encode($_SESSION['basket']) . "'";


$arr_fields[] = 'publ_time';
$arr_values[] = time();

// приводим к строке , implode - склеиваем  по запятой , получим строку, для полей
$str_fields = implode(',', $arr_fields);
$str_values = implode(',', $arr_values);


  // подключение к БД и записываем
$connect = new Connect();

// echo "INSERT INTO core_orders($str_fields) VALUES($str_values)";


$result = mysqli_query($connect->getConnection(),"INSERT INTO core_orders($str_fields) VALUES($str_values) ");
if ($result) {
    header('location: http://mikhit.beget.tech/basket.php' . '?wrong=1');
    // получаем пустую карзину
    $_SESSION['basket'] = [];
} else {
    echo 'Что то не так';
}


//Telegram Bot
// здесь место кода который отправит уведомление телеграмм

// https://api.telegram.org/bot1487268120:AAERob7JY4BnJSUfmkg7WlBKkHATnb5e47U/getUpdates


// мой телеграмм ID  из выше ссылки
// $chat_id = 1102811356;


// $text = '<pre>
//             Вам пришёл заказ <b>тест</b>
//             <a href="http://localhost/admin/?page=orders">Посмотреть в личном кабинете</a>
//           </pre>';

// $text = 'Вам пришёл заказ <b>тест</b>';

// $url = "https://api.telegram.org/bot1487268120:AAERob7JY4BnJSUfmkg7WlBKkHATnb5e47U/sendMessage?chat_id=$chat_id&text=$text&parse_mode=HTML";

// делаем запрос к УРЛУ через пхп
// file_get_contents($url);



// $text = 'Всем Привет';

// $url = "https://api.telegram.org/bot1487268120:AAERob7JY4BnJSUfmkg7WlBKkHATnb5e47U/sendMessage?chat_id=$chat_id&text=$text&parse_mode=HTML";

// file_get_contents($url);


// $text = 'Как дела?';

// $url = "https://api.telegram.org/bot1487268120:AAERob7JY4BnJSUfmkg7WlBKkHATnb5e47U/sendMessage?chat_id=$chat_id&text=$text&parse_mode=HTML";

// file_get_contents($url);





// Функция для высылания пару сообщений выше пример по одно три раза
// $text = 'Вам пришел заказ';
// sendMessage($chat_id, $text);
// $text = 'Всем привет';
// sendMessage($chat_id, $text);
// $text = 'Как дела?';
// sendMessage($chat_id, $text);

// function sendMessage($chat_id, $text){
//   file_get_contents ("https://api.telegram.org/bot1487268120:AAERob7JY4BnJSUfmkg7WlBKkHATnb5e47U/sendMessage?chat_id=$chat_id&text=$text&parse_mode=HTML");
// }





// для фото функции ниже на одну
// $photo = 'https://i05.fotocdn.net/s124/0b9ad7fcdd251db0/user_xl/2825638540.jpg';
// sendPhoto($chat_id, $photo);

// function sendPhoto($chat_id, $photo){
//   file_get_contents ("https://api.telegram.org/bot1487268120:AAERob7JY4BnJSUfmkg7WlBKkHATnb5e47U/sendPhoto?chat_id=$chat_id&photo=$photo");
// }





// $photo = 'https://i05.fotocdn.net/s124/0b9ad7fcdd251db0/user_xl/2825638540.jpg';

// $url_photo = "https://api.telegram.org/bot1487268120:AAERob7JY4BnJSUfmkg7WlBKkHATnb5e47U/sendPhoto?chat_id=$chat_id&photo=$photo";

// file_get_contents($url_photo);
$token ='bot1487268120:AAERob7JY4BnJSUfmkg7WlBKkHATnb5e47U';
$telegram = new Telegram($token);

$id = 1102811356;
$text = "Поступил новый заказ";
$photo = 'https://i05.fotocdn.net/s124/0b9ad7fcdd251db0/user_xl/2825638540.jpg';
$latitude = 55.045671;
$longitude = 60.107677;

$telegram->sendMessage($id, $text);
$telegram->sendPhoto($id, $photo);
$telegram->sendLocation($id, $latitude, $longitude);

?>