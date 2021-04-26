<!-- ПЕРВАЯ СТРАНИЦА ОТНОСИТЬЯ К Article -->
<?php
// подключаемся(набор настроек) к БД с помощью $_SERVER['DOCUMENT_ROOT'] ГЛОБАЛЬНАЯ ПЕРЕМЕННАЯ. уневерсальные метод для поиска файла
include_once($_SERVER['DOCUMENT_ROOT'].'/config.php');

// автоподключение всех класов
include_once($_SERVER['DOCUMENT_ROOT'].'/system/classes/autoload.php');
// include_once($_SERVER['DOCUMENT_ROOT'].'/system/classes/Connect.php');
// include_once($_SERVER['DOCUMENT_ROOT'].'/system/classes/UnitActions.php');
// include_once($_SERVER['DOCUMENT_ROOT'].'/system/classes/Unit.php');
// include_once($_SERVER['DOCUMENT_ROOT'].'/system/classes/ShowArticleInfo.php');
// include_once($_SERVER['DOCUMENT_ROOT'].'/system/classes/Article.php');


// передаём параметры нашего подключения

// $connect = new Connect();    !1
// $link = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
// mysqli_set_charset($link, 'utf8');

// $result = mysqli_query($connect->getConnection(), "SELECT * FROM `core_articles`");    !1
// передаём параметры нашего подключения через Article в unit
$result = (new Article())->getElements();

include($_SERVER['DOCUMENT_ROOT'] . '/components/head_doctype.php');

require_once($_SERVER['DOCUMENT_ROOT'] . '/components/header/index.php');

// var_dump($result);

// mysqli_close($link);

?>


<body>
    <main class="wrapper">
        <div class="text-align-center margin-top-60 nav">
            <h1 class="text-up">Новые поступления весны</h1>
            <p class="text-i">Мы подготовили для Вас лучшие новинки сезона</p>
            <a class="btn-10-30 margin-top-40" href="catalog.php?is_new=1">посмотреть новинки</a>
        </div>
        <div class="flex-box flex-wrap article-column margin-top-30">
            <!-- цикл для вывода, использовали кароткие тэги (удалили сначала и в конце тег php  и : заменили на фигурные скобки(иметь ввиду поддержка коротких тегов на сервере может быть отключена)) -->
            <? while($row = mysqli_fetch_assoc($result)): ?>
                <?php
                    // ($row['id']); row весь масив а мы берем только id, выводим с класса при помощи ОБЪЕКТА класса
                    $article = new Article($row['id']);
                    // искать по TITLE
                    // $article = new Article();
                    // $article->getElementByTitle('ДЖИНСОВЫЕ КУРТКИ');
                    // $article->getId($row['id']);
                    // пробуем через универсальный класс
                    // $article = new Unit();
                    // $article->getId($row['id']);
                    // $article->getTable('core_articles');   
                ?>
                <!-- фото бэкгроундом подтягиваеться из PHP -->
                <div class="main-article"style ="background-image: url('<?= $article->getField('photo')?>')"> 
                    <div>
                        <? if ($row['id'] == 4 || $row['id'] == 9) { ?>
                            <div class="flex-box padding-5">
                                <div class="main-article-arrow"></div>
                            </div>                                
                        <? } ?>
                        <div class="padding-5">
                            <? if ($row['id'] == 8 || $row['id'] == 7) { ?>
                                <div class="flex-box">
                                    <div class="main-article-logo"></div>
                                </div>                                
                            <? } ?>
                            <p class="text-up text-20px margin-0"> 
                                <?= $article->title()?>  
                            </p>
                        </div> 
                        <div class="text-italic padding-5">
                            <?= $article->getField('description')?> 
                        </div> 
                    </div>   
                </div>
            <?php endwhile; ?>
        </div>
        <div class="text-align-center margin-top-100">
            <h2>БУДЬ ВСЕГДА В КУРСЕ ВЫГОДНЫХ ПРЕДЛОЖЕНИЙ</h2>
            <p class="text-i">подписывайся и следи за новинками и выгодными предложениями.</p>
        </div>
        <div class="flex-box justify-content-center margin-top-40">
            <form action="system/controllers/users/mailing.php" method="POST" class="border-1px">
                <input class="text-i main-form-email" type="email" name="email"placeholder="e-mail">
                <input type="submit" value="подписаться!">
            </form>
        </div>
        
        <?php if (isset($_GET['wrong'])): ?>
            <div class="padding-5 text-align-center text-i-red">
                Некорректный e-mail. Попробуйте еще раз.
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['inDatabase'])): ?>
            <div class="padding-5 text-align-center text-i-red">
                Такой email уже получает рассылки нашего магазина
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['success'])): ?>
            <div class="padding-5 text-align-center text-i-red">
                Поздравляем, Вы успешно подписались!
            </div>
        <?php endif; ?>
    </main>
</body>


<?php

include($_SERVER['DOCUMENT_ROOT'] . '/components/footer/index.php');

?>