<?php
class Core_Events extends D_Core_Object {
	use D_Db_ActiveRecord;

	// object_id() hash
	public $object_hash = '';
	public $msg = '';

	static function __pk() {
		return ['eid'];
	}
	static function __fields() {
		return ['add_time', 'msg', 'object_hash'];
	}
}
?>