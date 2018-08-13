<?php
/**
 * Dump data from payment systems

 * @author Aleksey Arakelyan
 *
 */
class Payments_Callbacks extends D_Core_Object {
	use D_Db_ActiveRecord;

	public $add_time = 0;
	public $psys = '';
	public $data = '';

	static function __pk() {
		return ['cbid'];
	}
	static function __fields() {
		return ['add_time', 'psys','data'];
	}

	static function dump($psys, $data) {
		$new = new self();
		$new->add_time = time();
		$new->psys = $psys;
		$new->data = base64_encode(serialize($data));
		$new->save();
	}
}