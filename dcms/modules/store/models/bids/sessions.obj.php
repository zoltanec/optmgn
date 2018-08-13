<?php
class Store_Bids_Sessions extends D_Core_Object {
	use D_Db_ActiveRecord;

	public $prod_id = 0;
	public $str_time = 0;
	public $cls_time = 0;
	public $status = 0;
	public $step = 100;
	public $start_price = 0;
	public $last_price = 0;

	protected static function __pk() {
		return ['prod_id'];
	}

	protected function __save() {
		if($this->last_price == 0 && $this->start_price > 0 ){
			$this->last_price = $this->start_price;
		}
		$this->__save_record();
	}

	protected static function __fields() {
		return ['str_time', 'cls_time', 'status', 'start_price', 'last_price','step'];
	}


	protected function __get_stakes() {
		return Store_Bids_Stakes::find(['prod_id' => $this->prod_id],['limit' => 10, 'order' => 'stid DESC']);
	}

	protected function __get_total_stakes() {
		return Store_Bids_Stakes::count(['prod_id' => $this->prod_id]);
	}
	protected function __get_last_stake() {
		return $this->stakes[0];
	}
}