<?php
// namespace Nordic\Core;
// УНИВЕРСАЛЬНЫЙ КОД
// ПОВТОРЯЮЩИЙСЯ КОД для сокращения НАСЛЕДОВАНИЕ  в good и в articles!
//  ТОВАР 
//  КЭШИРОВАНИЕ 

// создаём класс для подключения повторяющего кода, наследования abstract не обезательно
// abstract-не можем создать экземпляр класса
// implements реализуем интерфес
abstract class Unit implements UnitActions
{
    //создание переменных свойства
    public $id;
    public $data;//переменная для кэширования
    
    // магические свойство php __construct  вызываеться автоматически при создании экземпляра( класс для избовления от ID)
    /*вызывается автоматически при создании экземпляра класса, сразу сообщается id (не надо вызывать в index.php)
        $id = null вместо $id - для того чтобы не было Fatal error если index.php не пробросил id при создании экземпляра класса*/
    public function __construct($id = null){
        $this->id = $id;
    }

    // получем id
    // можно удалить не используем используеться полимарфизм ВЫШЕ
    // public function getId($id){
    //     $this->id = $id;
    // }


    // ТЕСТ найдём элемемент по заголовку

    // public function getElementByTitle($title){
    //     $link = mysqli_connect('localhost', 'root', '', 'eshop');
    //         mysqli_set_charset($link, 'utf8');

    //         // выбераем конкретный товар
    //         $result = mysqli_query($link, "SELECT id FROM ".$this->setTable()." WHERE title='$title'");

    //         // получаем асациативный массив
    //         $row = mysqli_fetch_assoc($result);
    //         // момент кэширования
    //         $this->id = $row['id'];
    // }


    // указываем к какой табличке подключаемся
    //универсальный метод для выбора нужной таблицы из DB
    // можно удалить не используем используеться полимарфизм НИЖЕ
    public function getTable($table){
        $this->table = $table;
    }
    // полиморфизм переопределим метод
    //метод установки названия таблицы
    public function setTable(){
        return $this->table;
    }
    // создат экземпляр класса создаёт подключение и возвращает результат $this->setTable -метод установки названия таблицы
    // В классе Good этот метод переопределяем для фильтрации и вывода товара
    public function getElements(){
        $connect = new Connect();
        $result = mysqli_query($connect->getConnection(), "SELECT * FROM ".$this->setTable());
        return $result;
    }


    // уносим подключение от getField
    //метод для получения данных из БД
    public function getData(){
        //подключение к DB
        $link = mysqli_connect('localhost', 'mikhit_eshop', 'Qwerty11', 'mikhit_eshop');
            mysqli_set_charset($link, 'utf8');

            // выбераем конкретный товар
            //без метода getTable для выбора нужной таблицы из DB    $result = mysqli_query($link, "SELECT * FROM `core_articles` WHERE id=" . $this->id);
            //без метода setTable для автоматической подстановки названия нужной таблицы из DB    $result = mysqli_query($link, "SELECT * FROM ". $this->table .    " WHERE id=" . $this->id);
            $result = mysqli_query($link, "SELECT * FROM ".$this->setTable()." WHERE id=".$this->id);

            // получаем асациативный массив
            $row = mysqli_fetch_assoc($result);//запись в переменную данных из столбцов по полученному id в виде ассоциативного массива
            // момент кэширования
            $this->data = $row;

            mysqli_close($link);
    }

    // уневерсальный метод
    // реализуем из интерфейса
    public function getField($field){ //метод для получения данных полей
       //с кэшированием
        if(!$this->data){
            // подключаемся к БД
            $this->getData();
        }

        // возвращяем поле из $row
        return $this->data[$field];//выводим из кэша
    }

    //точечный метод для получения данных из полей используя getField
    public function title(){
        // смотрим и возвращяем значение
        return $this->getField('title');
    }

}
?>