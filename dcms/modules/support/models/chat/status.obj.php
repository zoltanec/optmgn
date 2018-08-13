<?php
class Support_Chat_Status extends D_Core_Object {
	use D_Db_ActiveRecord;

	public $operator;
	public $upd_time = 0;
	public $status = 0;

	static protected function __pk() {
		return ['operator'];
	}

	static protected function __fields() {
		return ['upd_time', 'status'];
	}

	static protected function __getIsOnline() {
		return (self::count(['upd_time' => ['>', time() - 86400], 'status' => 1]) > 0 );
	}

}