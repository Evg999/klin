        <footer class="wrapper flex-box footer-nav space-between">
            <div class="padding-30">
                <h3>КОЛЛЕКЦИИ</h3> 

                <?php
                    $connect = new Connect();
                    // делаем запрос к БД к каждой категории - получем категории, считаем каждую категорию
                    $categories = mysqli_query($connect->getConnection(), " SELECT * FROM categories");
                    // выводим в цикле , переводим к асациотивному масиву вытащили кол во,  в каждой этерации смотрим отдельную категорию
                    while($category = mysqli_fetch_assoc($categories)){
                    // считаем кол во товаров в каждой категории
                    $count =  mysqli_query($connect->getConnection(),"SELECT COUNT(*) as num FROM core_goods WHERE category_id=".$category['id']);
                    $info = mysqli_fetch_assoc($count);
                ?>

                <a href="/catalog.php?category_id=<?= $category['id'] ?>"><?= $category['title'] ?>(<?= $info['num'] ?>)</a>
                <?php } ?>

                <!-- считаем новинки -->
                <?php
                    $count =  mysqli_query($connect->getConnection(),"SELECT COUNT(*) as num FROM core_goods WHERE is_new=1");
                    $info = mysqli_fetch_assoc($count);
                ?>

                
                    <a href="/catalog.php?is_new=1">
                        Новинки (<?=$info['num']?>) 
                    </a>
                
            </div>
            <div class="padding-30">
                <h3>МАГАЗИН</h3>
                <a href="/about.php">О нас</a>
                <a href="/#">Доставка</a>
                <a href="/#">Работа с нами</a>
                <a href="/#">Контакты</a>
            </div>
            <div class="padding-30">
                <h3>МЫ В СОЦИАЛЬНЫХ СЕТЯХ</h3>
                <p>Сайт разработан <br> 
                под менторством INORDIC</p>
                <p>2020 © Все права защищены</p>
                <div class="flex-box">
                    <div class="facebook footer-social-icon"></div>
                    <div class="instagram footer-social-icon"></div>
                    <div class="linkedin footer-social-icon"></div>
                </div>
            </div>
        </footer>
    <script src="js/script.js"></script>
</body>
</html>