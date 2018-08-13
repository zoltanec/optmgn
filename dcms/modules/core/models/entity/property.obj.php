<?php
//!Класс свойства привязанного к iblock
class Core_Entity_Property extends D_Core_Object {
	public $block_id;
	public $prop_id;
	//!Имя свойства
	public $prop_name;
	//!Код свойства, используется для манипулирования со свойством
	public $prop_code;
	//!Тип свойства
	public $prop_type;
	//!Единицы измерения свойства
	public $prop_unit;
	//!Флаг ключа
	public $prop_key;
	//!Флаг инкремента
	public $increment;

	static public $form_types=array("Строка","Число","Текст","Текст/html","Дата/Время","Список в панели управления","Список на сайте", "Переключатель в панели управления", "Переключатель на сайте");
	static public $types=array("INT",
								"VARCHAR",
								"TEXT",
								"DATE",
								"TINYINT",
								"SMALLINT",
								"MEDIUMINT",
								"BIGINT",
								"INT",
								"DECIMAL",
								"FLOAT",
								"DOUBLE",
								"REAL",
								"BIT",
								"BOOLEAN",
								"SERIAL",
								"DATE",
								"DATETIME",
								"TIMESTAMP",
								"TIME",
								"YEAR",
								"CHAR",
								"VARCHAR",
								"TINYTEXT",
								"TEXT",
								"MEDIUMTEXT",
								"LONGTEXT",
								"BINARY",
								"VARBINARY",
								"TINYBLOB",
								"MEDIUMBLOB",
								"BLOB",
								"LONGBLOB",
								"ENUM",
								"SET");

	static function __fetch($prop_id) {
		return D::$db->fetchobject("SELECT * FROM #PX#_core_iblocks_properties WHERE prop_id={$prop_id} LIMIT 1",__CLASS__);
	}
	function object_id() {
		return $this->prop_id;
	}
	function delete() {
		D::$db->exec("DELETE FROM #PX#_core_iblocks_properties WHERE prop_id={$this->prop_id} LIMIT 1;");
	}
	function save() {
	if($this->prop_id == 0) {
			$this->prop_id=D::$db->exec("INSERT INTO #PX#_core_iblocks_properties(
																block_id,
																 prop_name, 
																 prop_code, 
																 prop_type,
																 prop_length,
																 prop_form_type,
																 prop_unit,
																 dependency)
														VALUES ({$this->block_id},
																'{$this->prop_name}', 
																'{$this->prop_code}', 
																'{$this->prop_type}',
																'{$this->prop_length}',
																'{$this->prop_form_type}',
																'{$this->prop_unit}',
																'{$this->dependency}')");
		}
		else {
			D::$db->exec("UPDATE #PX#_core_iblocks_properties SET prop_name = '{$this->prop_name}',
																prop_code = '{$this->prop_code}',
																prop_type = '{$this->prop_type}',
																prop_length = '{$this->prop_length}',
																prop_form_type='{$this->prop_form_type}',
																prop_unit = '{$this->prop_unit}',
																dependency = '{$this->dependency}'
																WHERE prop_id = {$this->prop_id} 
																AND block_id={$this->block_id} LIMIT 1");
		}
		return $this->prop_id;
	}
	
	function getValue($element_id){
		return D::$db->fetchvar("SELECT * FROM #PX#_core_iblocks_properties_values WHERE prop_id={$this->prop_id} AND element_id='{$element_id}'",__CLASS__);
	}
	static function getKeys($block_id){
		return D::$db->fetchobjects("SELECT * FROM #PX#_core_iblocks_properties WHERE block_id={$block_id} AND prop_key=1",__CLASS__);
		
	}
	static function getProperties($block_id){
		return D::$db->fetchobjects("SELECT * FROM #PX#_core_iblocks_properties WHERE block_id={$block_id}",__CLASS__);
	}
}
?>