
//AJAX  прелодер

// alert('dsssd');
// асинхронная выгрузка
// функция АЯКС - взять содержимое товаров и выгрузить на страницу после её загрузки 

//AJAX запрос - вывод товаров в каталоге
function renderGoods(){
    // new XMLHttpRequest - новый класс для создания асинхронных запросов которые будут работь от основного потока (// создаём новый экземпляр для запросов)
    // создание нового экземпляра класса для запросов
    let xhr = new XMLHttpRequest();

    //формирование url
    // вырезали строку, подставили ее в переменную запрос к страничке с товарами
    // Для фильтрации по М Х дитям нужно прописать ГЕТ параметр категории полученной
    // делаем переменной
    let url = 'http://mikhit.beget.tech/system/controllers/goods/catalog/index.php';

    // получаем всю поисковую строку с гет параметром для вывода товара GOOD  по фильтруМ Ж и детям
    // возвращяет все гет параметры
    let str_get = window.location.search.replace('?','');
    // и приклеиваем url  и всё что идёт после знака вопроса
    url = url + '?' + str_get;


    // к xhr пременяем метод open( пакзываем тип запроса(GET или POST) указываем адресс скрипта и указываем асинхронный или синхронный это запрос(true или folse))
    //запуск метода open() для установки параметров запроса (метод GET, куда - HTTP....., если true - то запрос асинхронный, иначе запрос синхронный)
    // url подставили переменную
    xhr.open('GET',url,true);
    

    
    // задаём заголовки для нашего запроса(задаём различные типы (setRequestHeader(какой тип) и (для правильной кодировки))
    // установили содержимое характеристи
    //задание заголовков для http запроса (application/x-form-urlencode - для отправки из формы)
    xhr.setRequestHeader('Content-type','application/x-form-urlencode')
    
    //при получении ответа на запрос
    // что бы запрос был полностью асинхронным нужно вызвать ещё одно сабытие onreadystatechange
    xhr.onreadystatechange = function(){
        // описываем что делает функция, когда будет получен ответ от сервера (xhr.onreadystatechange) в функции будут происходить (будем выводить ответ когда он придёт)
        if(xhr.readyState == 4 && xhr.status == 200){
            // если состояние 4 (выполнено) и статус 200 (ок) т.е. если всё хорошо

            // alert('fddffd');
            // для праверки
            
            // !!
            document.getElementById('catalog').innerHTML = xhr.responseText;
            // данные вставляем куда('catalog')  = xhr.responseText (сам текст объекта)
        }
    }
    // метод отправить (принемает строку с параметрами)
    xhr.send(null);
}
//показ гифки предзагрузки пока работает задержка времени для старта функции renderGoods
document.getElementById('catalog').innerHTML =  '<img src="img/prelouder.gif" alt="">';
    // создаём и  подставляе prelouder gif

// делаем задержку в загрузке
setTimeout(function(){
    
    // делаем задержку в загрузке
    renderGoods();
},1000);




//выпадающие фильтры товаров
let listObj = document.getElementsByClassName('filters-btn');
//console.log(listObj);

for (let i = 0; i < listObj.length; i++) {
    listObj[i].addEventListener('click', function () {
        let open = document.querySelectorAll('.display-none');
        //console.log(open);
        open[i].classList.toggle('display-block');
    });
}



//AJAX запрос - корзина - добавление товара
function toBasket() {
    // создание нового экземпляра класса для запросов
    let xhr = new XMLHttpRequest();

    //формирование url
    let url = 'http://mikhit.beget.tech/system/controllers/basket/to_basket.php';
    let str_get = window.location.search;
    url = url + str_get;

    //запуск метода open() для установки параметров запроса (метод GET, куда - HTTP....., если true - то запрос асинхронный, иначе запрос синхронный)
    xhr.open('GET', url, true);

    //при получении ответа на запрос
    xhr.onreadystatechange = function () {
        //если ответ положительный
        if (xhr.readyState == 4 && xhr.status == 200) {
            // alert(xhr.responseText);
            // налету меняем кол во в корзине при дабавления товара через карточку
            document.getElementById('basket-count').innerHTML = xhr.responseText;
        }
    };

    xhr.send(null);
}




//AJAX запрос - корзина - добавление товара fromBasket удаление из корзины
function fromBasket() {

    // записываем в переменную id  товаров которые в корзине для определения удаления одно из если мы нажмём на крести, 
    // для того что бы среди множества с могли определить какой именно товар нам удалять. действия происходят  в basket.php там же мы и заложили data-id, что бы сдесь его считать
    let id = event.target.getAttribute('data-id'); // получаем id

    // определяем крестиком какой именно товар ты выбрал для удаления, для удаление в нём находим ближайший родитель item и его за remove (удаляем)
    event.target.closest('.basket-row').remove(); //скрываем товар визуально

    // создание нового экземпляра класса для запросов
    let xhr = new XMLHttpRequest();

    //формирование url
    let url = 'http://mikhit.beget.tech/system/controllers/basket/from_basket.php';
    let str_get = '?id=' + id;
    url = url + str_get;

    //запуск метода open() для установки параметров запроса (метод GET, куда - HTTP....., если true - то запрос асинхронный, иначе запрос синхронный)
    xhr.open('GET', url, true);

    //при получении ответа на запрос
    xhr.onreadystatechange = function () {
        //если ответ положительный
        if (xhr.readyState == 4 && xhr.status == 200) {
            // alert(xhr.responseText);
            // налету меняем кол во в корзине при дабавления товара через карточку
            document.getElementById('basket-count').innerHTML = xhr.responseText;
        }
    };


    xhr.send(null);
}




//AJAX запрос - изменение суммы товаров в корзине при удалении товаров из корзины и при изменении способа доставки
function getSumm() {
    // создание нового экземпляра класса для запросов
    let xhr = new XMLHttpRequest();

    //формирование url
    let url = 'http://mikhit.beget.tech/system/controllers/basket/get_summ.php';

    //запуск метода open() для установки параметров запроса (метод GET, куда - HTTP....., если true - то запрос асинхронный, иначе запрос синхронный)
    xhr.open( 'GET', url , true );

    //при получении ответа на запрос
    xhr.onreadystatechange = function () {
        //если ответ положительный
        if (xhr.readyState == 4 && xhr.status == 200) {
            //и не равен - 0
            if (Number(xhr.responseText) != 0) {
                let indexSelect = document.getElementById('delivery-select').options.selectedIndex;
                let priceDelivery = 500;

                //заменяю сумму
                document.getElementById('summ-one').innerHTML = xhr.responseText + ' руб.';
                document.getElementById('summ-two').innerHTML = xhr.responseText + ' руб.';
                if (indexSelect == 0) {
                    document.getElementById('summ-total').innerHTML = Number(xhr.responseText) + priceDelivery + ' руб.';
                    document.getElementById('delivery-price').innerHTML = '';
                    document.getElementById('delivery-price-ajax').innerHTML = `
                                                                                <div id="delivery-price" class="flex-box justify-content-center">
                                                                                    <p class="margin-0 padding-5 width-45 text-align-end">Доставка:</p>
                                                                                    <p class="margin-0 padding-5 width-45">500 руб.</p>
                                                                                </div>
                                                                            `;
                } else {
                    document.getElementById('summ-total').innerHTML = xhr.responseText + ' руб.';
                    document.getElementById('delivery-price').innerHTML = '';
                    document.getElementById('delivery-price-ajax').innerHTML = `
                                                                                <div id="delivery-price" class="flex-box justify-content-center">
                                                                                    <p class="margin-0 padding-5 width-45 text-align-end">Доставка:</p>
                                                                                    <p class="margin-0 padding-5 width-45">оплата при получении</p>
                                                                                </div>
                                                                            `;
                }
            } else {
                //убираю и заменяю элементы со страницы
                document.getElementById('reset').innerHTML = '';
                document.getElementById('summ-one-block').innerHTML = 'Ваша корзина пуста';
                document.getElementById('basket-delete').innerHTML = '';
                document.getElementById('summ-two-block').innerHTML = '';
                document.getElementById('delivery-price').innerHTML = '';
                document.getElementById('summ-total-block').innerHTML = '';
            }
        }
    };

    xhr.send(null);
}