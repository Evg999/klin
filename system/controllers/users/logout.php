<?php
// для кнопки Выход

setcookie('user_id',0,time() - 3600,'/');// убиваем куки
header('Location: http://mikhit.beget.tech/catalog.php');// редерект в каталог
?>