<?

// Делаем ИНТЕРФЕЙС 
// ИНТЕРФЕЙС описывает только действие (методы абстрактный) или константы (getField получить поле)
// ДЛЯ Article а тачнее INDEX

// создаём и называем
interface ShowArticleInfo{
     // описание только действе, находяться только методы или константы, метод должен быть абстрактным
    public function description();
    public function title();
    public function photo();
    
}
?>