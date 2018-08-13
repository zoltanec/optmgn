<?php
class Store_Lists extends D_Core_Object {
	use D_Db_ActiveRecord;

	public $prod_id = 0;
	public $name = '';
	public $priority = 0;

	static protected function __pk() {
		return ['prod_id','name'];
	}
	static protected function __fields() {
		return ['priority'];
	}

	function __get_product() {
		return D_Core_Factory::Store_Product(intval($this->prod_id));
	}
}
?>