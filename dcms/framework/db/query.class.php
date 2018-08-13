<?php
class D_Db_Query {
	//самой SQL выражение
	private $query = '';
	//массив условий
	private $where_conditions = array();
	//работа с SQL выражениями
	function __construct($query = '') {
		$this->query = $query;
	}
	function &where() {
		return $this;
	}
	function &_and($rule = '',$replacements = array()) {
		$this->where_conditions[] = array('type' => 'and', 'rule' => $rule, 'replacements'=>$replacements);
		return $this;
	}

	static function getWhere($conditions = array()) {
		if(!is_array($conditions)) {
			throw new D_Core_Exception('$conditions is not an array', EX_OTHER_ERROR);
		}
		return (sizeof($conditions) > 0 ) ? " WHERE ".implode(' AND ', $conditions) : "";
	}
	/**
	 * Преобразовываем запрос к типу строки
	 */
	function __toString() {
		$where = '';
		//обходим все условия
		foreach($this->where_conditions AS $i => $condition) {
			if($i != 0) {
				$where.= ' '.$condition['type'];
			}
			//добавляем правило из условия
			$where.= ' '.$condition['rule'];
		}
		$from = array();
		$to  = array();
		if(!empty($where)) {
			$from[] = '#WHERE#'; $to[] = ' WHERE '.$where;
			$from[] = '#WHEREPART#'; $to[] = ' '.$this->where_conditions[0]['type'].$where;
		} else {
			$from[] = '#WHERE#';$to[] = '';
			$from[] = '#WHEREPART#';$to[] = '';
		}
		$result = str_replace($from,$to,$this->query);
		return $result;
	}
}
?>
