<?php
class Store_Bids_Stakes extends D_Core_Object {
	use D_Db_ActiveRecord;

	public $add_time = 0;
	public $prod_id = 0;
	public $owner = '';
	public $price;
	public $step = 100;

	static protected function __pk() {
		return ['stid'];
	}

	static protected function __fields() {
		return ['add_time','prod_id','owner','price'];
	}

	protected function __get_phone_private() {
		return "+".$this->owner[0]." ".str_repeat('x', strlen($this->owner) - 5).' '.substr($this->owner, -4,2).' '.substr($this->owner, -2);
	}
}
