<!-- GOOGLE Катра не подключена -->
<!DOCTYPE html>
<html>
    <head>
            <title>Мы на картах</title>
            <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>

            <?php

                // подключаемся(набор настроек) к БД с помощью $_SERVER['DOCUMENT_ROOT']. уневерсальные метод для поиска
                include_once($_SERVER['DOCUMENT_ROOT'].'/config.php');
                //  автоподключение всех класов
                include_once($_SERVER['DOCUMENT_ROOT'].'/system/classes/autoload.php');

                include($_SERVER['DOCUMENT_ROOT'] . '/components/head_doctype.php');

                require_once($_SERVER['DOCUMENT_ROOT'] . '/components/header/index.php');
                
            ?>

            <script
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA_9pk730Zz5FQTIz-OvvYCHl5frLiKdUo&callback=initMap&libraries=&v=weekly"
            defer
            ></script>

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

            <script>
            "use strict";

            let map;

            function initMap() {
                map = new google.maps.Map(document.getElementById("map"), {
                center: {
                    lat: 55.0450000,
                    lng: 60.1083300,
                },
                zoom: 8,
                });

                //автоматическое создание меток
                //создание массива данных из таблицы в БД
                let points = JSON.parse(getShops());

                //в цикле перебираем массивы для подставления координат в метки и вывода меток на карту
                for (let i = 0; i < points.length; i++) {
                    let a = Number(points[i].latitude);
                    let b = Number(points[i].longitude);

                    //создание метки и добавление метки на карту
                    let marker = new google.maps.Marker({position: {lat: a, lng: b}, map: map});

                    let contentString =
                                        `<h1 id="firstHeading" class="firstHeading"> ${points[i].title} </h1>` +
                                
                                        `<p> ${points[i].adress} </p>` +
                                        `<p> ${points[i].description}, <a href="http://project_2/index.php">` +
                                        "Наш сайт</a> " +
                                        `<div><img class="geo-photo-size" src=" ${points[i].photo} "/></div>`;

                    const infowindow = new google.maps.InfoWindow({
                        content: contentString,
                    });

                    marker.addListener("click", () => {
                        infowindow.open(map, marker);
                    });
                } 
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