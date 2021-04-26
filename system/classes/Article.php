<?
// namespace Nordic\Core;
// ПЛИТКА НА ГЛАВНОЙ ,КЛАСС вкл его на главной и вы

// extends расширяем фунционал, НАСЛЕДУЕМ от класса Unit
// implements реализуем интерфес
class Article extends Unit implements ShowArticleInfo
{
    // переопределение метода полиморфизм,  пишим название таблицы ,переопределили метода из unita
    public function setTable(){
        return 'core_articles';
    }
    
    // реализуем из интерфейса
    public function photo(){
        return $this->getField('photo');
    }

    public function title(){
        return $this->getField('title');
    }

    public function description(){
        return $this->getField('description');
    }
}
?>