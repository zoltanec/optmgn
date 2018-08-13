<?php
class Store_CartItem extends D_Core_Object {
	use D_Db_ActiveRecord;

	public $order_id = 0;
	public $pack_id = 0;
	public $hash = '';
	public $quantity = 0;
	public $price = 0;
	public $meta = '';

	static function __fetch($order_id = '', $pack_id = '', $hash = '') {
		return self::__fetch_record($order_id, $pack_id, $hash);
	}

	static protected function __table() {
		return '#PX#_store_order_contains';
	}
	static protected function __pk() {
		return ['order_id','pack_id','hash'];
	}
	static protected function __fields() {
		return ['quantity','meta','prod_id','price','descr'];
	}
}
?>