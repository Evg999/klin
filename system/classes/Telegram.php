<?php

// namespace Nordic\Core;

class Telegram {

    private $token;

    public function __construct($token) {
        $this->token = $token;
    }

    //функция для сообщений
    function sendMessage($id, $text) {
        file_get_contents("http://api.telegram.org/$this->token/sendMessage?chat_id=$id&text=$text&parse_mode=html");
    }

    //функция для фото
    function sendPhoto($id, $photo) {
        file_get_contents("http://api.telegram.org/$this->token/sendPhoto?chat_id=$id&photo=$photo");
    }

    //функция координат
    function sendLocation($id, $latitude, $longitude) {
        file_get_contents("http://api.telegram.org/$this->token/sendLocation?chat_id=$id&latitude=$latitude&longitude=$longitude");
    }
}

?>