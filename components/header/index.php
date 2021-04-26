<? session_start();?>
<!-- session_start(); для использования в коде сессии -->


<header class="wrapper flex-box space-between padding-30 align-items-center">
    <!-- ДЛЯ фильтрации в ХЕДЕРЕ для вывода фильтрации  -->
    <div class="flex-box align-items-center">
        <a href="/index.php" class="header-logo"></a>
        <div class="header-nav margin-left-30">
            <!-- блок с сылкой
            "href="catalog.php?category_id=1"
            category_id=1 задаём ГЕТ параметр самостоятельно -->
            <!-- если выбран Гет параметр или выбрана категория ID назначем жирный шрифт -->
            <a class="<?if(isset($_GET['category_id']) && $_GET['category_id'] == 1){?> is-bold <?}?> "href="/catalog.php?category_id=1">Женщинам</a>
            <a class="<?if(isset($_GET['category_id']) && $_GET['category_id'] == 2){?> is-bold <?}?> "href="/catalog.php?category_id=2">Мужчинам</a>
            <a class="<?if(isset($_GET['category_id']) && $_GET['category_id'] == 3){?> is-bold <?}?> "href="/catalog.php?category_id=3">Детям</a>
            <a class="<? if(isset($_GET['is_new']) && $_GET['is_new'] == 1) { ?> is-bold <? } ?>" href="/catalog.php?is_new=1">Новинки</a>
            <a href="/about.php">О Нас</a>
        </div>
    </div>
    <div class="flex-box header-user">
        <div class="flex-box align-items-center margin-left-30">
            <div class="header-account header-icon"></div>

            <?php if (isset($_COOKIE['user_id'])) { ?>

                Привет, <?= (new User($_COOKIE['user_id']))->login() ?> (<a class="header-user-out" href="/system/controllers/users/logout.php">Выйти</a>)

            <?php } else { ?>
                <a href="/auth/index.php">Войти</a>
            <?php } ?>

        </div>
        <div class="flex-box align-items-center margin-left-30">
            <div class="header-basket header-icon "></div>
            <a href="/basket.php">Корзина(<span id="basket-count"> <?= isset($_SESSION['basket']) ? count($_SESSION['basket']) : 0?></span>) </a> 
        </div>
    </div>

</header>