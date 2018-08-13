<?php
class Support_Messages extends D_Core_Object {
	use D_Db_ActiveRecord;

	public $msgid = 0;
	public $title = '';
	public $msg = '';
	public $attachments = 0;
	public $mtype = 'in';

	static function __fields() {
		return ['subject', 'msg', 'msg_raw', 'tid', 'add_time','mtype'];
	}
	static function __pk() {
		return ['msgid'];
	}

}
?>