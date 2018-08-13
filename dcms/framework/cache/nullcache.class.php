<?php
//!Класс для эмуляции кэширования, если xcache не установлен
/**
 * В этом случае необходимо выставить $cfg['cache']='none';
 *
 */
class D_Cache_Nullcache {
	//!Время кэширования
    public $time = 120;
    //!Колличество запросов
    public $requests = 0;
    //!Проверка существования кэша
    function __isset($varname) {
        return false;
    }
    //!Получение данных из кэша
    function __get($varname) {
    	++$this->requests;
        return false;

    }
    //!Занесение в кэш
    function set($varname,$value,$cachetime = 120) {
        return true;
    }
     //!Очистка кэша
    function delete($varname) {
    	return true;
    }
}
?>