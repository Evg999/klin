<?
    session_start();

    // подключаемся(набор настроек) к БД с помощью $_SERVER['DOCUMENT_ROOT']. уневерсальные метод для поиска
    include_once($_SERVER['DOCUMENT_ROOT'].'/config.php');
    // автоподключение всех класов
    include_once($_SERVER['DOCUMENT_ROOT'].'/system/classes/autoload.php');
    

    // проверяем пользователя для допуска в админ
    // tckb юзер не может попасть в адимн то мы его редиректем 
    
    $user = new User($_COOKIE['user_id']);
    
    if($user->getField('user_group') != 2){
        header('Location: http://mikhit.beget.tech/catalog.php');

    }

?>


<!doctype html>
<html lang="ru">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="Пример на bootstrap 4: Базовая панель администратора с фиксированной боковой панелью и навигационной панелью. Версия v4.5.">

        <title>Панель администратора </title>

        <!-- Bootstrap core CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

        
        <style>
            .bd-placeholder-img {
                font-size: 1.125rem;
                text-anchor: middle;
                -webkit-user-select: none;
                -moz-user-select: none;
                -ms-user-select: none;
                user-select: none;
            }

            @media (min-width: 768px) {
                .bd-placeholder-img-lg {
                    font-size: 3.5rem;
                }
            }
        </style>
        <!-- Custom styles for this template -->
        <link href="dashboard.css" rel="stylesheet">
    </head>

  <body>

<nav class="navbar navbar-dark bg-dark flex-md-nowrap p-0 shadow">
  <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="#">Nordic IT</a>
  <input class="form-control form-control-dark w-100" type="text" placeholder="Search" aria-label="Search">
  <ul class="navbar-nav px-3">
    <li class="nav-item text-nowrap">
        <span class="nav-link" style="color: red;"><?= $user->login() ?></span>
        <a class="nav-link" href="../system/controllers/users/logout.php">Выйти</a>
    </li>
  </ul>
</nav>

<div class="container-fluid">
    <div class="row">
        <nav class="col-md-2 d-none d-md-block bg-light sidebar">
            <div class="sidebar-sticky">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="?page=orders">
                            <span data-feather="file"></span>
                            Заказы
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="?page=items">
                            <span data-feather="shopping-cart"></span>
                            Товары
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="?page=users">
                            <span data-feather="users"></span>
                            Клиенты
                         </a>
                    </li>
                </ul>
            </div>
        </nav>

        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <div class="btn-toolbar mb-2 mb-md-0"></div>
            </div>

<!--создание нового товара-->
            <? if (isset($_GET['new'])) { ?>

                <form action="../system/controllers/goods/create.php" method="POST" enctype="multipart/form-data" style="width: 80%">
                    <div class="form-group">
                        <input type="text" class="form-control margin-0-important" name="title" placeholder="Название товара" >
                    </div>
                    <div class="form-group margin-0">
                        <input type="number" class="form-control margin-0-important" name="articul" placeholder="Артикул">
                    </div>
                    <div class="form-group">
                        <input type="number" class="form-control" name="price" placeholder="Цена"> руб.
                    </div>
                    <div class="form-group">
                        <input type="file" class="form-control" name="photo" style="border: none;">
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlSelect1">Категория</label>
                        <select class="form-control" name="category_id">
                            <option value="1">Женщинам</option>
                            <option value="2">Мужчинам</option>
                            <option value="3">Детям</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlSelect1">Тип товара</label>
                        <select class="form-control" name="type_id">
                            <option value="1">Куртки</option>
                            <option value="2">Джинсы</option>
                            <option value="3">Обувь</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">Описание товара</label>
                        <textarea class="form-control" name="description" rows="3"></textarea>
                    </div>
                    <div class="form-group form-check">
                        <input type="checkbox" class="" name="is_new" value="1"> Новинка
                    </div>
                    <div>
                        <button type="submit" class="btn btn-primary">Создать товар</button>
                    </div>          
                </form>

            <!--изменение существующего в БД товара-->        
            <? } elseif (isset($_GET['change'])) { ?>

                <? $good = new Good($_GET['id']); ?>

                <form action="../system/controllers/goods/update.php" method="POST" enctype="multipart/form-data" style="width: 80%">

                    <!--скрытое поле для передачи данных в какой таблице по какому id изменить товар-->
                    <input type="hidden" name="id" value="<?= $good->getField('id') ?>">

                    <div class="form-group">
                        <input type="text" class="form-control margin-0-important" name="title" value="<?= $good->getField('title') ?>">
                    </div>
                    <div class="form-group margin-0">
                        <input type="number" class="form-control margin-0-important" name="articul" value="<?= $good->getField('articul') ?>">
                    </div>
                    <div class="form-group">
                        <input type="number" class="form-control" name="price" value="<?= $good->getField('price') ?>"> руб.
                    </div>
                    <div class="form-group">
                        <img src="http://localhost/eshop/<?= $good->getField('photo') ?>" style="width: 200px;">
                        <input type="file" class="form-control" name="photo" style="border: none;">
                    </div>

            <!--ручное создание ассоциативного массива-->
                    <? $category = new Category($good->getField('category_id')) ?>
            
                    <? $arr_category = [  
                        '1' => 'Женщинам',
                        '2' => 'Мужчинам',
                        '3' => 'Детям'
                    ] ?>

                    <div class="form-group">
                        <label for="exampleFormControlSelect1">Категория</label>
                        <select class="form-control" name="category_id">
                            <option value="<?= $category->getField('id') ?>"><?= $category->getField('title') ?></option>

                            <? foreach ($arr_category as $key => $value) { ?>
                                <? if ($key != $category->getField('id')) { ?>
                                    <option value="<?= $key ?>"><?= $value ?></option>
                                <? } ?>
                            <? } ?>

                        </select>
                    </div>

            <!--автоматическое создание ассоциативного массива-->
                    <? $type = new Type($good->getField('type_id')) ?>

                    <?php

                    $connect = new Connect(); 

                    //запрос к DB
                    $result = mysqli_query($connect->getConnection(), "SELECT * FROM itemtypes " );
                    $arr_type = [];

                    //создание ассоциативного массива с данными из DB
                    while ($row = mysqli_fetch_assoc($result)) {
                        $arr_type[$row['id']] = $row['title'];
                    }  

                    ?>

                    <div class="form-group">
                        <label for="exampleFormControlSelect1">Тип товара</label>
                        <select class="form-control" name="type_id">
                            <option value="<?= $type->getField('id') ?>"><?= $type->getField('title') ?></option>

                            <? foreach ($arr_type as $key => $value) { ?>
                                <? if ($key != $type->getField('id')) { ?>
                                    <option value="<?= $key ?>"><?= $value ?></option>
                                <? } ?>
                            <? } ?>

                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">Описание товара</label>
                        <textarea class="form-control" name="description" rows="3"><?= $good->getField('description'); ?></textarea>
                    </div>
                    <div class="form-group form-check">
                        <input type="hidden" name="is_new" value="0" /> <!--кастом для отправки 0 если нет галочки в чекбоксе, без этой строки будет игнор на состояние чекбокса и всегда будет отправляться 1-->
                        <input type="checkbox" <? if ($good->getField('is_new')) { ?> checked <? } ?> class="" name="is_new" value="1"> Новинка
                    </div>
                    <div>
                        <button type="submit" class="btn btn-primary">Сохранить</button>
                    </div>          
                </form>

            <? } else { ?>

            <? } ?>

<!--создание нового клиента-->
            <? if (isset($_GET['new-user'])) { ?>

                <form action="../system/controllers/users/create.php" method="POST" enctype="multipart/form-data" style="width: 80%">
                    <div class="form-group">
                        <input type="text" class="form-control margin-0-important" name="login" placeholder="Логин пользователя" >
                    </div>
                    <div class="form-group margin-0">
                        <input type="email" class="form-control margin-0-important" name="email" placeholder="E-mail пользователя">
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" name="password" placeholder="Пароль пользователя">
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlSelect1">Группа пользователей</label>
                        <select class="form-control" name="user_group">
                        <option value="1">Пользователь</option>
                        <option value="2">Менеджер</option>
                        </select>
                    </div>
                    <div>
                        <button type="submit" class="btn btn-primary">Создать Клиента</button>
                    </div>          
                </form>

            <!--изменение существующего клиента-->        
            <? } elseif (isset($_GET['change-user'])) { ?>

                <? $user = new User($_GET['id']); ?>

                <form action="../system/controllers/users/update.php" method="POST" enctype="multipart/form-data" style="width: 80%">

                    <!--скрытое поле для передачи данных в какой таблице по какому id изменить клиента-->
                    <input type="hidden" name="id" value="<?= $user->getField('id') ?>">

                    <div class="form-group">
                        <input type="text" class="form-control margin-0-important" name="login" value="<?= $user->getField('login') ?>">
                    </div>
                    <div class="form-group margin-0">
                        <input type="email" class="form-control margin-0-important" name="email" value="<?= $user->getField('email') ?>">
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" name="password" value="<?= $user->getField('password') ?>">
                    </div>

            <!--автоматическое создание ассоциативного массива -->
                    <? $userGroup = new UserGroup($user->getField('user_group')) ?>

                    <?php

                    $connect = new Connect(); 

                    //запрос к DB
                    $result = mysqli_query($connect->getConnection(), "SELECT * FROM core_user_groups " );

                    $arr_userGroup = [];

                    //создание ассоциативного массива с данными из DB
                    while ($row = mysqli_fetch_assoc($result)) {
                        $arr_userGroup[$row['id']] = $row['title'];
                    }                    
                    ?>
            
                    <div class="form-group">
                        <label for="exampleFormControlSelect1">Группа пользователей</label>
                        <select class="form-control" name="user_group">
                            <option value="<?= $userGroup->getField('id') ?>"><?= $userGroup->getField('title') ?></option>

                            <? foreach ($arr_userGroup as $key => $value) { ?>
                                <? if ($key != $userGroup->getField('id')) { ?>
                                 <option value="<?= $key ?>"><?= $value ?></option>
                                <? } ?>
                            <? } ?>

                        </select>
                    </div>
                    <div>
                        <button type="submit" class="btn btn-primary">Изменить Клиента</button>
                    </div>          
                </form>

            <? } else {?>

            <? } ?>


<!--страница Товары-->
            <? if (isset($_GET['page']) && $_GET['page'] == 'items') { ?>
      
                <div>
                    <a href="?new=item" class="btn btn-primary btn-lg active" role="button" aria-pressed="true">Добавить товар</a>
                </div>
                <h2>Товары</h2>
                <div class="table-responsive">
                    <table class="table table-striped table-sm">
                        <thead>
                            <tr>
                                <th>#id</th>
                                <th>Название</th>
                                <th>Цена</th>
                                <th>Артикул</th>
                                <th>Описание</th>
                                <th>Категория</th>
                                <th>Тип товара</th>
                                <th>Новинка</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?
                                // подключение к БД
                                $connect = new Connect();

                                // делаем запрос к БД \(COUNT)- посчитать кол-во (id) и положить их в переменную NUM
                                $result = mysqli_query($connect->getConnection(), "SELECT * FROM core_goods " );

                                //создание ассоциативного массива с данными из DB и вывод товаров в цикле
                                while ($info = mysqli_fetch_assoc($result)) { 
                                  $category = new Category($info['category_id']);
                                  $type = new Type($info['type_id']);                    
                                  ?>
                                    <tr>
                                        <td><?= $info['id'] ?></td>
                                        <td>
                                            <a href="?change=item&id=<?= $info['id'] ?>" target="_blank">
                                                <?= $info['title'] ?> 
                                            </a>
                                        </td> 
                                        <td><?= $info['price'] ?></td>
                                        <td><?= $info['articul'] ?></td>
                                        <td><?= $info['description'] ?></td>
                                        <td><?= $category->getField('title') ?></td>
                                        <td><?= $type->getField('title') ?></td>
                                        <td><?= $info['is_new'] != 0 ? 'новинка' : '' ?></td>
                                    </tr>
                                <? } ?>     
                        </tbody>
                    </table>
                </div>
                <div>
                    <a href="?new=item" class="btn btn-primary btn-lg active" role="button" aria-pressed="true">Добавить товар</a>
                </div>

<!--страница Клиенты-->        
            <? } elseif (isset($_GET['page']) && $_GET['page'] == 'users') { ?>

                <div>
                    <a href="?new-user=user" class="btn btn-primary btn-lg active" role="button" aria-pressed="true">Добавить Клиента</a>
                </div>
                <h2>Клиенты</h2>
                <div class="table-responsive">
                    <table class="table table-striped table-sm">
                        <thead>
                            <tr>
                                <th>#id</th>
                                <th>Логин</th>
                                <th>E-mail</th>
                                <th>Группа пользователей</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php

                            $connect = new Connect();

                            //запрос к DB
                            $result = mysqli_query($connect->getConnection(), "SELECT * FROM core_users " );

                            //создание ассоциативного массива с данными из DB и вывод товаров в цикле
                            while ($info = mysqli_fetch_assoc($result)) { 
                                $group = new UserGroup($info['user_group']);
                                ?>
                                <tr>
                                    <td><?= $info['id'] ?></td>
                                    <td>
                                        <a href="?change-user=item&id=<?= $info['id'] ?>" target="_blank">
                                        <?= $info['login'] ?> 
                                        </a>
                                    </td>
                                    <td><?= $info['email'] ?></td>
                                    <td><?= $group->getField('title') ?></td>
                                </tr>
                            <? } ?>
                        </tbody>
                    </table>
                </div>
                <div>
                <a href="?new-user=user" class="btn btn-primary btn-lg active" role="button" aria-pressed="true">Добавить Клиента</a>
                </div>

<!--страница Заказы-->        
                <? } elseif (isset($_GET['page']) && $_GET['page'] == 'orders') { ?> 

                    <h2>Заказы</h2>
                    <div class="table-responsive">
                        <table class="table table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>#id</th>
                                    <th>Имя</th>
                                    <th>Телефон</th>
                                    <th>E-mail</th>
                                    <th>Товары</th>
                                    <th>Статус</th>
                                    <th>Время заказа</th>
                                    <th>Время обработки</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php

                                $connect = new Connect();

                                //запрос к DB
                                $result = mysqli_query($connect->getConnection(), "SELECT * FROM core_orders " );

                                //создание ассоциативного массива с данными из DB
                                while ($info = mysqli_fetch_assoc($result)) {
                                    $status = new Status($info['order_status']);
                                    ?>
                                    <tr>
                                        <td><?= $info['id'] ?></td>
                                        <td><?= $info['first_name'] ?></td>
                                        <td>
                                            <a href="tel:<?= $info['phone'] ?>">
                                                <?= $info['phone'] ?>  
                                            </a>                   
                                        </td>         
                                        <td>
                                            <a href="mailto:<?= $info['email'] ?>">
                                                <?= $info['email'] ?>
                                            </a>  
                                        </td>  
                                        <td><?= $info['goods'] ?></td>
                                        <td style="color: <?= $status->getField('color') ?>; background: <?= $status->getField('background') ?>"><?= $status->getField('title') ?></td>
                                        <td><?= date('d-m-Y в H:i', $info['publ_time']) ?></td>
                                        <td><?= $info['last_update'] != 0 ? date('d-m-Y в H:i', $info['last_update']) : 'не просмотрено' ?></td>
                                    </tr>
                                <? } ?>
                            </tbody>
                        </table>
                    </div>  
                <? } else { ?>
            <? } ?>
        </main>
    </div>
</div>  

</body>
</html>