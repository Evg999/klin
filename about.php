<!-- подключаем карту  -->
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>

        <title>Мы на картах</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <?php

            // делаем API для about

            // подключаемся(набор настроек) к БД с помощью $_SERVER['DOCUMENT_ROOT']. уневерсальные метод для поиска
            include_once($_SERVER['DOCUMENT_ROOT'].'/config.php');
            // автоподключение всех класов
            include_once($_SERVER['DOCUMENT_ROOT'].'/system/classes/autoload.php');

            include($_SERVER['DOCUMENT_ROOT'] . '/components/head_doctype.php');

            require_once($_SERVER['DOCUMENT_ROOT'] . '/components/header/index.php');
        ?>


        <script src="https://api-maps.yandex.ru/2.1/?apikey=2fdf78f0-1244-48cc-82c7-4cb113b3cbf9&lang=ru_RU" type="text/javascript"> </script>

        <style type="text/css">
            /* Always set the map height explicitly to define the size of the div
            * element that contains the map. */
            #map {
                height: 60%;
            }
            /* Optional: Makes the sample page fill the window. */
            html,
            body {
                height: 100%;
                margin: 0;
                padding: 0;
            }
        </style>
       
        <script type="text/javascript">
            ymaps.ready(init);

            function init(){
                var myMap = new ymaps.Map("map", {
                    center: [55.76, 37.64],
                    zoom: 15
                });

                //  доп функция для добавления метки из БД
                let points = JSON.parse(getShops());

                for (let i = 0; i < points.length;i++){
                    console.log(points[i].title);
                    //Создание метки
                    let myPlacemark = new ymaps.Placemark(
                        [points[i].latitude, points[i].longitude],
                        {
                            // hintContent: 'Собственный значок метки',
                            // balloonContent: 'Это красивая метка'
                            hintContent: points[i].title,
                            balloonContent: '<b>'+points[i].title+'</b><div>'+points[i].address+'</div><div>'+points[i].description+'</div><div><img src="'+points[i].photo+'"/></div>'
                        }
                    );
                    //добавления метки
                    myMap.geoObjects.add(myPlacemark);
                }
                //  доп функция для добавления метки из БД



                //Создание метки без БД
                var myPlacemark = new ymaps.Placemark(
                    [55.761, 37.645]
                );
                //добавления метки
                myMap.geoObjects.add(myPlacemark);

                //Создание метки2
                var myPlacemark = new ymaps.Placemark(
                    [55.762, 37.646]
                );
                //добавления метки2
                myMap.geoObjects.add(myPlacemark);
            }

        // AJAX запрос для получения массива данных для отображения меток на картах яндекс и гугл
        // соеденяем БД метки через php  и json через аякс с js сверху метки без БД
        function getShops() {
            // создание нового экземпляра класса для запросов
            let xhr = new XMLHttpRequest();

            let url = 'http://localhost/api/1.0/shops/get/all/index.php';

            // к xhr пременяем метод open( пакзываем тип запроса(GET или POST) указываем адресс скрипта и указываем асинхронный или синхронный это запрос(true или folse))
            //запуск метода open() для установки параметров запроса (метод GET, куда - HTTP....., если true - то запрос асинхронный, иначе запрос синхронный)
            // url подставили переменную
            xhr.open('GET',url,false);

            // метод отправить (принемает строку с параметрами)
            xhr.send();


            return xhr.responseText;
        }
        </script>

    </head>


    <body class="wrapper">

        <div id="map"></div>
        
        <?php

            include($_SERVER['DOCUMENT_ROOT'] . '/components/footer/index.php');

        ?>  
        
    </body>

</html>