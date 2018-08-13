<?php
class dDatabaseException extends D_Core_Exception {

}

/**
 * Класс для удобной работы с объектами хранящимися в базе данных, загрузка, сохранение
 */
class D_Db_Driver {
	protected $query_history = array();
	protected $prefix = '';
	public $q_count = 0;

	function fetchvar($query,$arguments = []) {
		return $this->__fetchvar($this->prepare($query),$arguments);
	}
	//выполняем сохранение объекта в базу данных
	function exec($query, $arguments = array()) {
		return $this->__exec($this->prepare($query), $arguments);
	}

	/** FETCH ONE LINE FROM RESULT SET AND RETURN AS ASSOCIATIVE
	 *
	 *
	 * @param unknown_type $query
	 */
	function fetchline($query,$arguments = 0) {
		return $this->__fetchline($this->prepare($query));
	}

	/**
	 * Fetch many objects from database and initialize them by class
	 *
	 * @param string $query
	 */
	function fetchobjects($query,$class_name = 'stdClass', $arguments = array()) {
		return $this->__fetchobjects($this->prepare($query),$class_name, $arguments);
	}

	/** Fetch single object and initiate it by class */
	function fetchobject($query, $class_name = 'stdClass', $arguments = array()) {
		return $this->__fetchobject($this->prepare($query), $class_name, $arguments);
	}

	/** Fetchlines */

	function fetchlines($query,$arguments = array()) {
		return $this->__fetchlines($this->prepare($query), $arguments);
	}

	function fetchlines_clear($query, $arguments = array()) {
		return $this->__fetchlines_clear($this->prepare($query));
	}
	function fetchobjects_clear($query, $class_name = 'stdClass', $arguments = array()) {
		return $this->__fetchobjects_clear($this->prepare($query), $class_name);
	}


	function prepare($query) {
		$this->connect();
		$query = str_replace(array('#PREFIX#_','#PX#_'),array($this->prefix.'_',$this->prefix.'_'),$query);
		$this->query_history[] = $query;
		$this->q_count++;
		return $query;
	}
	/**
	 * Get history of SQL queries
	 */
	function getHistory() {
		return $this->query_history;
	}
}
 ?>