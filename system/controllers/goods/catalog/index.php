<!-- страничка с товарами делаем запрос JS к этому файлу и плюхаем её в каталог
-->


<?php
 // автоподключение всех класов
 include_once($_SERVER['DOCUMENT_ROOT'].'/system/classes/autoload.php');

 // подключаемся(набор настроек) к БД с помощью $_SERVER['DOCUMENT_ROOT']. уневерсальные метод для поиска
 include_once($_SERVER['DOCUMENT_ROOT'].'/config.php');


// include_once($_SERVER['DOCUMENT_ROOT'].'/system/classes/Connect.php');
// include_once($_SERVER['DOCUMENT_ROOT'].'/system/classes/UnitActions.php');
// include_once($_SERVER['DOCUMENT_ROOT'].'/system/classes/Unit.php');
// include_once($_SERVER['DOCUMENT_ROOT'].'/system/classes/Good.php');


    
//  передаём параметры нашего подключения
// $connect = new Connect();
    // $link = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    // mysqli_set_charset($link, 'utf8');

    // $result = mysqli_query($connect->getConnection(), "SELECT * FROM `core_goods`");

    // var_dump($result);


    // // передаём параметры нашего подключения через Good в unit
    $result = (new Good())->getElements();
    include($_SERVER['DOCUMENT_ROOT'] . '/components/head_doctype.php');

    // mysqli_close($link);
?>

<!--создание карточки товара-->
<div class="flex-box flex-wrap nav">
    <!-- цикл для вывода, использовали короткие тэги (удалили сначала и в конце тег php и : заменили на фигурные скобки(иметь ввиду поддержка коротких тегов на сервере может быть отключена)) -->
    <!-- переводим к асациотивному масиву, выводим в цикле товар -->
    <? while($row = mysqli_fetch_assoc($result)){ ?>
        <? $good = new Good($row['id']); ?>
        <div class="item padding-30" > 
            <div class="item-photo">
                <a href="">
                 <img src="<?= $good->photo()?> " alt="">
                </a>
            </div>
            <div class="padding-10">
                <b>
                <!-- открываем гет параметры (зашиваем id)  -->
                    <a href="card.php?id=<?=$good->getField('id')?>">
                        <?=  $good->title()?>  
                    </a>
                </b>
            </div>
            <div class="padding-10">
                <!-- стрелочная функция -->
                <?=  $good->price()?> руб.
            </div>
            <!-- Пример: тема STATIC: отличие от обычного метода, у STATIC не нужно создавать экземпляр класса, обычные методы пренодлежат экземплярукласса, а в STATIC мы можем использовать само имя класса 
            ПУМАИМНУКАДАТАИМ (::) -->
            <div>
                <?= Good::getQuality() ?> 
            </div>
              <!-- Пример: тема STATIC свойства: вызываем статическое свойство, обращаемся через константу -->
            <div>
                <?if (Good::HAS_GOOD) {?>
                    Товар в наличии
                <?}?>
            </div>
            <div>
                <?if (Good::$has_good) {?>
                    Товар в наличии <?=Good::$has_good ?>
                <?}?>
            </div>
        </div>
    <?}?>
</div>


