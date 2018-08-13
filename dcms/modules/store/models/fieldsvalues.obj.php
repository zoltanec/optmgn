<?php
class Store_FieldsValues extends D_Core_Object {

	static function __fetch($prod_id, $code) {
		$field = D::$db->fetchobject("SELECT * FROM #PX#_store_categories_fields_values WHERE prod_id = '{$prod_id}' AND code = '{$code}' LIMIT 1",__CLASS__);
		if(empty($field)) {
			$field = new self();
			$field->prod_id = $prod_id;
			$field->code = $code;
		}
		return $field;
	}

	protected function __object_id() {
		return array($this->prod_id, $this->code);
	}

	static function getForProduct($prod_id) {
		return D::$db->fetchobjects_clear("SELECT a.code, a.* FROM #PX#_store_categories_fields_values a WHERE a.prod_id = '{$prod_id}'",__CLASS__);
	}

	protected function __save() {
		D::$db->exec("INSERT INTO #PX#_store_categories_fields_values (prod_id,code,content) VALUES ('{$this->prod_id}', '{$this->code}', '{$this->content}')
		ON DUPLICATE KEY UPDATE content = VALUES(content)");
	}

	protected function __get_plist() {
		$list = explode("\n", $this->content);
		$result = array();
		foreach($list AS $item) {
			list($name, $price) = explode(':', $item);
			$result[] = array('name' => $name, 'price' => $price);
		}
		return $result;
	}
}
