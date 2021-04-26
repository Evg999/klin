<?
// namespace Nordic\Core;

// КЛАСС не наследуем UNIT, подключение к бд реализовываем

class Connect{
public $link;

// магические свойство php __construct  вызываеться автоматически при создании экземпляра( класс для избовления от ID)
    /*вызывается автоматически при создании экземпляра класса, сразу сообщается id (не надо вызывать в index.php)
        $id = null вместо $id - для того чтобы не было Fatal error если index.php не пробросил id при создании экземпляра класса*/
    public function __construct(){
        // создали подключение
        $link = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        
        //проверка на подключение к DB
        if(!$link) {
            echo 'Нет подключения к базе данных';
            die(); //остановка работы скрипта
        }
        //кодировка для общения с DB
        mysqli_set_charset($link, 'utf8');
        // создаём ключ
        $this->link = $link;
    }
    // метод подключения вызывание
    public function getConnection(){
        return $this->link;
    }
}
?>