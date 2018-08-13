<!--
Структура файла для построения SQL таблицы:

declare table users:
	attr uid int incremented,
	attr username varchar(30) default 'none',
	attr password varchar(30) default 'none',
	attr about text default 'dermo',
	attr active bool default true,
	attr messages int between 0 and 30000 default 0,
	attr stuf1 bigint from 100 default 200,
	index username,
	index password;
 -->
<?php

class ormObject {
	protected $changedFields = array();
	//protected $container = array();
	protected $table_name = 'mmg_articles';
	protected $initialized = false;


	/**
	 * Получение свойства объекта
	 *
	 * @param string $fieldname - название поля, чье значение надо получить
	 */
	function __get($fieldname) {
		return $this->container[$fieldname];
	}


	function isExists() {
		if(!$this->initialized) {
		}
	}

	function __set($fielname, $value) {
		$this->changedFields[$fieldname] = true;
		$this->container[$fielname] = $value;
	}

	function save() {
		foreach($this->changedFields AS $fieldname) {
			$query[] = $fieldname." = '".$value."'";
		}
		$queryRequest = implode(',',$query);
		return 'UPDATE ';
	}

	function delete() {

	}

	function incr() {
	
	}
	
	

}
?>