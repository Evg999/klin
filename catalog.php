<!-- Страница КАТАЛОГА -->
<link rel="stylesheet" href="css/style.css">
<!-- подключить css -->

    <!-- создаём блок в который будем запихивать всё содержимое js скрипта -->

<?   
   include_once($_SERVER['DOCUMENT_ROOT'].'/config.php');
   // автоподключение всех класов
   include_once($_SERVER['DOCUMENT_ROOT'].'/system/classes/autoload.php');
 
   include($_SERVER['DOCUMENT_ROOT'] . '/components/head_doctype.php');
 
   require_once($_SERVER['DOCUMENT_ROOT'] . '/components/header/index.php');
   



//  создание фильтра по колонке category_id из таблицы core_goods и таблицы categories с использованием класса Category  
//считываем ГЕТ параметр каторый прописали в хедере пишим канструкцию иф элсе для отображения имени категории при выборе  иначе показываем все товары если не чего не выбрано

// проверяем есть ли Гет вообще параметр(isset($_GET['category_id'])) тогда выводим все товары
// создаём в БД  categories ДЕТЯМ МУЖЧИНАМ ЖЕНЩИНАМ order_row обратный сталбец

    if(isset($_GET['category_id'])){ // проверяем если есть то делаем экземпляр класса и тогда
        $category = new Category($_GET['category_id']);// подключаем Category Класс  прокидываем ГЕТ
        $cat_name = $category->getField('title'); //и такоеже будем имя по тайтлу Мужчина Детям или Женщинам
        // иначе показываем все товары если не чего не выбрано 
    }elseif (isset($_GET['is_new'])) {
        $cat_name = 'Новинки';
    } else {
        $cat_name = 'Все товары';
    }
?>

<!-- ХЛЕБНЫЕ КРОШКИ -->
<div class="breadcrumbs wrapper nav padding-30 text-up text-12px">
    <a class="text-12" href="index.php">Главная</a> / <a href="catalog.php">Категории</a> / <?= $cat_name ?>
</div>

<!-- выводим в заголовке категорию выбранную при клике <h1>$cat_name?></h1> -->


<!-- фильтры по Категориям ПЕРВЫЙ в товарах так же как в Хедере, создаём БД новое табличка type -->
<div class="wrapper text-align-center">
    <h1 class="text-up"><?= $cat_name ?></h1>
    <p class="text-i">Все товары</p>
    <div class="filters flex-box justify-content-center text-i nav-i">
        <div class="padding-10">          
            <div class="filters-btn">Категории</div>
            <div class="display-none z-index-1">
                <ul>
                    <li>
                        <!-- проверям естьли в Гет что либо 'category_id' если она есть выводим а иначе нечего не выводим -->
                        <a href="?type=1<?= isset($_GET['category_id']) ? '&category_id='.$_GET['category_id'] : ''?>">Куртки</a>
                    </li>
                    <li>
                        <a href="?type=2<?= isset($_GET['category_id']) ? '&category_id='.$_GET['category_id'] : ''?>">Джинсы</a>
                    </li>
                    <li>
                        <a href="?type=3<?= isset($_GET['category_id']) ? '&category_id='.$_GET['category_id'] : ''?>">Обувь</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="padding-10">
            <div class="filters-btn">Размер</div>
            <div class="display-none z-index-1">
                <ul>
                    <li><a href="#">S</a></li>
                    <li><a href="#">M</a></li>
                    <li><a href="#">L</a></li>
                </ul>
            </div>
        </div>
        <div class="padding-10">
            <div class="filters-btn">Стоимость</div>
            <div class="display-none z-index-1 text-14px">
                <ul>
                    <li><a href="#">0-1000 руб.</a></li>
                    <li><a href="#">1000-3000 руб.</a></li>
                    <li><a href="#">3000-6000 руб.</a></li>
                    <li><a href="#">6000-20000 руб.</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- подгружаем товар -->
<div id="catalog" class="wrapper"></div>

</div>
<!-- фильтрация, фильтрация по типу, пагинация -->
<div class="pagination flex-box flex-center">
    <!-- автамотически считать страницы для пагинации -->
    <?php
        // кол-во товаров всего(задаём из БД)

        // подключение к БД
        $connect = new Connect();

        // вспомагательная строчка для категории для Пагинации если категории нет то не чего не произойдёт
        $cat_str=''; //вспомогательная строка для категории чтобы при клике в ячейки пагинации не выкидывало на - Все товары

        // вспомагательная строчка для типов когда выбираем Обувь и тавара болеше появляеться ещё страница для это переменная поможет избежать при переоде на вторую выброс на все товары
        $type_str='';//вспомогательная строка для типов


        // Условие для ПАГИНАЦИИ и ФИЛЬТРА М Ж Диетям когда нажимает на фильтр число страниц должно отображить реальное значение как в GOOD класс
        $filter= '';//убираем Notice: Undefined variable: filter in ...
        // фильтрация по категориям (разделам)
        // фильтрация по категориям (разделам)
        // если параметр Гет пустой то всё остаёться как есть, в JS тоже считывает категория гет параметр необходимо так же и там прокинуть
        // $category_id=$_GET['category_id'] если категория АЙДИ есть
        // isset проверка есть ли вообже переменная категория Гет параметр есть ли существует ли (isset($_GET['category_id'])
        if(isset($_GET['category_id']) && $category_id = $_GET['category_id']){
           $filter .= " AND category_id=$category_id ";

            // вспомагательная строчка для категории для Пагинации 
           $cat_str ="&category_id=$category_id";
        }


         // фильтрация по типу категории товара 
         if(isset($_GET['type']) && $type_id = $_GET['type']){
            $filter .= " AND type_id=$type_id ";
        // вспомагательная строчка фильтрация по типу категории товара  
            $type_str ="&type=$type_id";
         }
         
         $is_new_str = '';
         // фильтрация по новинкам для отображения нормальной пагинации
         if(isset($_GET['is_new']) && $is_new = $_GET['is_new']){
            $filter .= " AND is_new=$is_new ";
        // вспомагательная строчка 
            $is_new_str ="&is_new=$is_new";
         }


        //  ПАГИНАЦИЯ
        // делаем запрос к БД \(COUNT)- посчитать кол-во (id) и положить их в переменную NUM
        $result = mysqli_query($connect->getConnection(),"SELECT COUNT(id) as num FROM core_goods WHERE id>0 $filter");
        // переводим к асациотивному масиву вытащили кол во COUNT
        $info = mysqli_fetch_assoc($result);
        // кол-во товаров всего ПАГИНАЦИЯ
        $amount =  $info['num']; //в переменную помещаем данные из массива с ключом num
        // на странице сколько тавара отображаем
        $per_page = 2;
        // ceil округляем вверх (вдруг товаров 7)
        // $amount/$per_page кол-во таваров делем на кол во страниц
        $pages_amount = ceil($amount/$per_page);//ceil округляет в большую сторону

        //выделение в пагинации активной страницы
        $page = 1;
        // если есть значение page то пишем $page = $_GET['page']
        if(isset($_GET['page'])){
            $page = $_GET['page'];
        
        }
    ?>
    <!-- выводим в цикле -->
    <!-- $i=1 номер стр -->
    <?for($i=1; $i <= $pages_amount; $i++){?>
        <!-- выводим вёрстку -->
        <!-- если i совпадает $page прибавляем класс page-active -->
        <!--  if($i == $page) { ?> page-active  выделяем былым цветом -->
        <div class="amount padding-10 nav-white <? if($i == $page) { ?> page-active nav <? } ?>">
            <!-- обвалакиваем ссылкой номер стр и при клике на номер стр отправляем ГЕТ параметр и получали номер стр и попадала в скрипт -->
            <!-- выводим как ссылку -->
            <a href="?page=<?=$i?><?=$cat_str?><?=$type_str?><?= $is_new_str ?>">
                <?=$i ?>
            </a>
        </div>
    <? } ?>
</div>


<?php

include($_SERVER['DOCUMENT_ROOT'] . '/components/footer/index.php');

?>


 