<?php
// namespace Nordic\Core;
// Класс
// Ктегории Мужчины Женщины Дети для Фильтра для отображения товара в Catolog  прокудываем имя таблички 

class Category extends Unit 
{
    // переопределение метода
    public function setTable(){
        return 'categories';
    }
   
}