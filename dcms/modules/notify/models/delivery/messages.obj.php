<?php
class Notify_Delivery_Messages extends D_Core_Object {
	use D_Db_ActiveRecord;

	public $msgid = 0;
	public $add_time = 0;
	public $address = '';
	public $status = 0;
	public $id = 'UNSET';
	public $msg = '';

	static function __pk() {
		return ['msgid'];
	}

	static function __fields() {
		return ['address', 'add_time','status', 'id','msg', 'did'];
	}

	/**
	 * List of available statuses
	 *
	 * 0 - message not sended
	 * 1 - message sended, we don't know if it delivered
	 * 2 - message successfully delivered
	 * 3 - unable to send message, some kind of error
	 *
	 */


}