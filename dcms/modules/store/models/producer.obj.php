<?php
//! Класс производителей товаров
class Store_Producer extends D_Core_Object {
  	static $cacheself = 200;
    //Производитель
    public $producer_id = 0;
    public $producer_name = '';
	//Описание производителя
    public $descr = '';
    //Страна производителя
    public $country_id = '';

    static function __fetch($producer_id) {
        return D::$db->fetchobject("SELECT a.*, b.name as country_name FROM #PX#_store_producers a 
        							LEFT OUTER JOIN #PX#_core_country b using(country_id) 
        							WHERE producer_id={$producer_id} LIMIT 1",__CLASS__);
    }

    function object_id() {
		return $this->producer_id;
	}
	function delete() {
        D::$db->exec("DELETE FROM #PX#_store_producers WHERE producer_id={$this->producer_id} LIMIT 1");
	}
    protected function __save() {
	if($this->producer_id == 0) {
			$this->producer_id=D::$db->exec("INSERT INTO #PX#_store_producers (producer_name, country_id, descr) 
											VALUES ('{$this->producer_name}', '{$this->country_id}', '{$this->descr}')");
		}
		else {
			D::$db->exec("UPDATE #PX#_store_producers SET producer_name = '{$this->producer_name}',
		    	                              		country_id = '{$this->country_id}',
		    	                              		descr = '{$this->descr}' WHERE producer_id = {$this->producer_id} LIMIT 1");
		}
		return $this->producer_id;
    }
	static function getAllProducers() {
		return D::$db->fetchobjects("SELECT a.*, b.name as country_name FROM #PX#_store_producers a 
									LEFT OUTER JOIN #PX#_core_country b using(country_id)",__CLASS__);
	}
	static function getCountries() {
		return D::$db->fetchlines("SELECT * FROM #PX#_core_country");
	}
}
?>