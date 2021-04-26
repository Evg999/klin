<?php
// namespace Nordic\Core;
//ТИП ID для хлебных крошек
// Ктегории Мужчины Женщины Дети для Фильтра для отображения товара в Catolog  прокудываем имя таблички 

class Type extends Unit 
{
    // переопределение метода
    public function setTable(){
        return 'itemtypes';
    }
   
}