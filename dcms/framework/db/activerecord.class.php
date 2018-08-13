<?php
trait D_Db_ActiveRecord {


	/**
	 * Get default table name for class.
	 * Because we use class names with full module path we can
	 * just add prefix
	 */
	static function __table() {
		return '#PX#_'.strtolower(get_called_class());
	}

	/**
	 * Provide default object_id based on primary key values
	 */
	protected function __object_id() {
		$keys = self::__pk();
		$array = [];
		foreach($keys AS $key) {
			$array[] = $this->{$key};
		}
		return $array;
	}


	/**
	 * Default delete action
	 */
	protected function __delete() {
		return $this->__delete_record();
	}

	/**
	 * Default save action
	 */
	protected function __save() {
		return $this->__save_record();
	}

	/**
	 * Fetch record by it's private keys
	 */
	static public function __fetch() {
		return call_user_func_array(array(get_called_class(),'__fetch_record'), func_get_args());
	}

	protected function __new() {
		if(isset($this->add_time) && $this->add_time == 0 ) $this->add_time = time();

		return true;
	}


	function __save_record() {
		$keys = self::__pk();
		$table = self::__table();
		$fields = self::__fields();

		$fields_all = array_merge($keys, $fields);

		$insert_values = [];

		if(isset($this->{'upd_time'})) {
			$this->upd_time = time();
		}

		foreach($fields_all AS $field) {
			$insert_values[] = ":".$field;
			if(!in_array($field, $keys)) {
				$update_values[] = "{$field} = VALUES({$field})";
			}
			$execut_values[':'.$field] = (isset($this->{$field})) ? $this->{$field} : '';
		}

		// insert or update values with composite primary keys
		if($keys > 0 || ( sizeof($keys) == 1 && !empty($this->{$keys[0]}) ) ) {
			$query = "INSERT INTO {$table} (".implode(',', $fields_all).") VALUES (".implode(',', $insert_values).") ON DUPLICATE KEY UPDATE ".implode(', ', $update_values);
		} else {
			// fill object with some default parameters if needed
			$this->__new();
			// look's like we have only one PK, and we need to execute create query
			$query = "INSERT INTO {$table} (".implode(',', $fields).") VALUES (".implode(',', $insert_values).") ON DUPLICATE KEY UPDATE ".implode(', ', $update_values);
		}

		$id = D::$db->exec($query, $execut_values);

		// if this object have only one PK and it's 0, we will get new value from database
		if(sizeof($keys) == 1 && $this->{$keys[0]} == 0) {
			$this->{$keys[0]} = $id;
		}

		return $this->__object_id();
	}

	/**
	 * Delete record from database
	 */
	function __delete_record() {
		$keys = self::__pk();
		$table = self::__table();

		foreach($keys AS $field) {
			$request[] = "{$field} = :{$field}";
			$execut_values[':'.$field] = $this->{$field};
		}

		D::$db->exec("DELETE FROM {$table} WHERE ".implode(' AND ', $request)." LIMIT 1", $execut_values);
	}

	/**
	 * Fetch record from database
	 */
	static function __fetch_record() {
		$keys = self::__pk();
		$table = self::__table();
		$arguments = func_get_args();

		if(sizeof($arguments) != sizeof($keys)) {
			throw new D_Core_Exception("Fetching with wrong keys number!");
		}

		$request = array();
		$query = array();

		for($x = 0; $x < sizeof($keys); $x++) {
			$name  = $keys[$x];
			$value = $arguments[$x];
			$query[] = "{$name} = :{$name}";
			$request[$name] = $value;
		}
		return D::$db->fetchobject("SELECT * FROM {$table} WHERE ".implode(' AND ',$query)." LIMIT 1", get_called_class(), $request);
	}

	/**
	 * Get list of available values for specific field
	 */
	static public function distinct($field, $filter = []) {
		list($where, $execut_values) = self::getFilter($filter);
		$fields = self::__fields();
		$table = self::__table();
		$pk = self::__pk();

		if( !( in_array($field, $fields) || in_array($field, $pk) ) ) {
			throw new D_Core_Exception("Wrong field for model: {$field}");
		}

		$result = D::$db->fetchlines("SELECT DISTINCT({$field}) AS field FROM {$table} {$where}", $execut_values);
		$parsed = [];
		foreach($result AS &$v) {
			$parsed[] = $v['field'];
		}
		return $parsed;
	}

	static public function count($filter = []) {
		list($where, $execut_values) = self::getFilter($filter);
		$fields = self::__fields();
		$table = self::__table();
		$pk = self::__pk();

		return intval(D::$db->fetchvar("SELECT COUNT(1) AS field FROM {$table} {$where}", $execut_values));
	}

	static public function remove($filter = []) {
		list($where, $execut_values) = self::getFilter($filter);
		$fields = self::__fields();
		$table = self::__table();
		$pk = self::__pk();

		D::$db->exec("DELETE FROM {$table} {$where}", $execut_values);
	}

	static protected function getFilter($filter) {
		$request = [];
		$execut_values = [];

		$fields = self::__fields();
		$keys = self::__pk();

		$fields_all = array_merge($fields, $keys);


		foreach($filter AS $field => $value) {
			if(!in_array($field, $fields_all) && !preg_match('/[\(\)]/', $field)) {
				continue;
			}

			$var_name = strtoupper(substr(md5($field),0,6));

			if(is_array($value)) {
				if($value[0] == 'in') {
					$request[] = "{$field} IN ";
				} else {
					$request[] = "{$field} {$value[0]} :{$var_name}";
					$execut_values[':'.$var_name] = $value[1];
				}
			} else {
				$request[] = "{$field} = :{$var_name}";
				$execut_values[':'.$var_name] = $filter[$field];
			}
		}
		$where = ( sizeof($request) > 0 ) ? " WHERE ".implode(' AND ', $request) : "";

		return [$where, $execut_values];
	}


	static public function find($filter = array(), $options = array()) {
		$fields = self::__fields();
		$table = self::__table();
		$keys = self::__pk();

		$fields_all = array_merge($fields, $keys);

		$request = array();
		$execut_values = array();

		// query limits
		$limit = (isset($options['limit'])) ? " LIMIT ".intval($options['limit']) : "";
		$order = (isset($options['order'])) ? " ORDER BY ".$options['order'] : "";

		foreach($filter AS $field => $value) {
			if(!in_array($field, $fields_all) && !preg_match('/[\(\)]/', $field)) {
				//var_dump(preg_match('/[\(\)]/', $field));
				//echo "EExt";
				continue;
			}

			$var_name = strtoupper(substr(md5($field),0,6));

			if(is_array($value)) {
				if($value[0] == 'in') {
					if(sizeof($value[1]) == 0) continue;
					$prot = [];
					foreach($value[1] AS $val) {
						$prot[] = D::$db->quote($val);
					}
					$request[] = "{$field} IN (".implode(",", $prot).")";
				} else {
					$request[] = "{$field} {$value[0]} :{$var_name}";
					$execut_values[':'.$var_name] = $value[1];
				}
			} else {
				$request[] = "{$field} = :{$var_name}";
				$execut_values[':'.$var_name] = $filter[$field];
			}
		}

		$where =(sizeof($request) > 0) ? " WHERE ".implode(' AND ', $request) : "";

		//var_dump($where);exit;

		if(isset($options['count'])) {
			return D::$db->fetchvar("SELECT COUNT(1) FROM {$table} {$where}", $execut_values);
		}

		if(isset($options['limit']) && $options['limit'] == 1) {
			// fetch only one object
			return D::$db->fetchobject("SELECT  * FROM {$table} {$where} {$order} LIMIT 1", get_called_class(), $execut_values);
		} else {
			return D::$db->fetchobjects("SELECT * FROM {$table} {$where} {$order} {$limit}", get_called_class(), $execut_values);
		}
	}

	static function get($filter = [], $options = []) {
		$result = self::find($filter, $options);
		if(!$result) {
			throw new D_Core_Exception("Objects not geted",EX_NO_SUCH_OBJECT);
		}
		return $result;
	}

}
?>