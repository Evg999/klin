<?php
// namespace Nordic\Core;

//  ТОВАР 
//  Класс важный, 
// для описания товара, а методы нужны для отображения конкретных значений которые мы будем брать из БД, этот класс подключаеться и берёт данные из БД 

// // extends расширяем фунционал, НАСЛЕДУЕМ от класса Unit
class Good extends Unit 
{
    // ПРИМЕР static
    // статическое свойство( не сработало нужно через константу)
    public static $has_good = 1;//  ПРИМЕР тема STATIC свойства

    // константу(перепесать нельзя)
    const HAS_GOOD = 1;
    // константу(перепесать нельзя) используем в метиоде для примера
    const IS_REAL = 1;

    // ещё один пример метода
    public static function getGoodStaticInfo()
    {
        return self::IS_REAL; // const = self
    }
    public static function getStaticVar(){
        return self::$has_good;
    }

    // МЕТОД STATIC отличие только в солове STATIC и в теле не может быть $this(псевдо элементы)
    public static function getQuality() //  ПРИМЕР тема STATIC метода
    { 
        if(static::getGoodStaticInfo()){ //const вместо this    const = self
            $text = "Этот товар официальный";
        }else{
            $text = "Этот товар реплика";
        }
        echo $text;
    }//  НАПРИМЕР тема STATIC

    // ПРИМЕР static


     // переопределение метода полиморфизм,  пишим название таблицы ,переопределили метода из unita
    public function setTable(){
        // возвращяем значение свойства подставляем в Unit  
        return 'core_goods';
    }
    
    public function price(){
        // getField-получить поле, универсальный метод создаём для вывода всех полей
        return $this->getField('price');
    }

    public function photo(){
        // getField-получить поле, универсальный метод создаём для вывода всех полей
        return $this->getField('photo');
    }
    public function article() {
        return $this->getField('article');
    }


    // переопределяем метод  создаём новое условие  getElement из Unit для ФИЛЬТР ТОВАРОВ 
    // В классе Good этот метод переопределяем для фильтрации и вывода товара
    public function getElements(){
        $connect = new Connect();

        // пустая переменная для отображеиния если не выбраны Гет параметры для отображения все Товаров
        // $result = mysqli_query($connect->getConnection(), "SELECT * FROM ".$this->setTable(). " WHERE id>0 $filter LIMIT $from,  $limit");
        $filter = '';//убираем Notice: Undefined variable: filter in ...
        // фильтрация по категориям (разделам)
        // если параметр Гет пустой то всё остаёться как есть, в JS тоже считывает категория гет параметр необходимо так же и там прокинуть
        // $category_id=$_GET['category_id'] если категория АЙДИ есть
        // isset проверка есть ли вообже переменная категория Гет параметр есть ли существует ли (isset($_GET['category_id'])
        if(isset($_GET['category_id']) && $category_id=$_GET['category_id']){//isset($_GET['category_id']) --- убирает Notice: Undefined index: category_id in ...
            // добавляем строчку фильтрации или нет канкатинируем
           $filter .= " AND category_id=$category_id ";
        }

        //фильтрация по типу КАТЕГОРИИ ПЕРВЫЙ товара
        if(isset($_GET['type']) && $type_id=$_GET['type']){
            $filter .= " AND type_id=$type_id ";
        }

        //фильтрация по НОВИНКАМ
        if(isset($_GET['is_new']) && $is_new=$_GET['is_new']){
            $filter .= " AND is_new=$is_new ";
        }


        //ПАГИНАЦИЯ, расчет товаров на страницу

        // расчёт товаров на страницу
        $page = 1;//если страница не задана то будем подставлять авто 1 по умолчанию
        // если переданн параметр назавём его ГЕТ 'page'  (выбранна страница)
        if(isset($_GET['page'])){
            // говарим что $page равно $_GET['page'] если атоматически то один если же выбор другой стр другой ном подставиться
            $page = $_GET['page'];
        }
        // какое кол-во товара выводим на каждую из страниц ПРИДЕЛЫ
        $limit = 2;

        //если страница 1 - стартовое значение 0
        // если страница 2 - старт 2
        // если страница 3 - старт 4
        // подбираем формулу 
        $from = ($page - 1)*$limit;//если страница 1 - старт с 0, если страница 2 - старт с 2, если страница 3 - старт с 4

        // LIMIT 2, 2 доставание с такого то по такой (с второго показать два следующих) ПРЕДЕЛЫ
        $result = mysqli_query($connect->getConnection(), "SELECT * FROM ". $this->setTable(). " WHERE id>0 $filter LIMIT $from, $limit"); //LIMIT 2, 3 - предел, выводит 3 товара из БД после второго
        return $result;
    }
}
?>