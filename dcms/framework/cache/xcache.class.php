<?php
//! Класс для кэширования байт-кода
class D_Cache_XCache {
	//!Время кэширования (Почему-то нигде не используется, Леха надо удалить наверное)
    public $time = 120;
    //!Колличество запросов
    public $requests = 0;
    //!Кэшируем результаты возврата кэша (Нигде не используется наверное удалить надо)
    static protected $cache_pool = array();
    //!Префикс кэша
    private $cache_prefix = '';
    public $flush = false;

    //!Инициализация префикса кэша
    function __construct($cache_prefix = '') {
    	$this->cache_prefix = $cache_prefix;
    }
    //!Проверка существования кэша
    /**
     * @param $varname - закэшированная переменная
     */
    function __isset($varname) {
    	// flush cache if needed, otherwise check cacher
        return ($this->flush) ? false : xcache_isset($this->cache_prefix.$varname);
    }
    //!Получение данных из кэша
    /**
     * Функция производит перевод полученного из кэша
     * байт-поточного представления переменной в код.
     * @param $varname - закэшированная переменная
     *
     */
    function __get($varname) {
    	++$this->requests;
        return unserialize(xcache_get($this->cache_prefix.$varname));

    }
    //!Занесение в кэш
    /**
     * @param $varname - кэшируемые данные
     * @param $value - значение данных предварительно переводится в байт-поточный представление
     * @param $varname - закэшированные данные
     */
    function set($varname,$value,$cachetime = 120) {
    	return xcache_set($this->cache_prefix.$varname, serialize($value),$cachetime);
    }
    //!Очистка кэша
    /**
     * @param $varname - кэшируемые данные
     */
    function delete($varname) {
    	return xcache_unset($this->cache_prefix.$varname);
    }
}
?>