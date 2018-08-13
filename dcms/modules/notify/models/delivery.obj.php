<?php
class Notify_Delivery extends  D_Core_Object {
	use D_Db_ActiveRecord;

	public $did = 0;
	public $lid = 0;
	public $add_time = 0;
	public $mode = 'email';
	public $name = 'NONAME';
	public $msg = '';

	static protected function __pk() {
		return ['did'];
	}
	static protected function __fields() {
		return ['add_time', 'mode', 'name', 'msg', 'lid' ];
	}

	static function getModes() {
		return ['sms','email'];
	}

	protected function __get_total() {
		return Notify_Delivery_Messages::count( ['did' => $this->did] );
	}

	protected function __get_sended() {
		return Notify_Delivery_Messages::count(['did' => $this->did, 'status' => ['!=', '0' ]]);
	}


	/**
	 * Build messages list
	 */
	function buildMessages() {
		D::$db->exec("INSERT INTO #PX#_notify_delivery_messages (address, add_time, mode, msg, did)
		SELECT b.address, UNIX_TIMESTAMP(), a.mode, a.msg, a.did FROM #PX#_notify_delivery a
		LEFT OUTER JOIN #PX#_notify_delivery_listitems b ON ( a.lid = b.lid )
		WHERE a.did = :did", [ 'did' => $this->did ]);
	}

}
?>