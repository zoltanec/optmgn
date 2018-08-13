<?php
class Core_Ipc_Messages extends D_Core_Object {
	use D_Db_ActiveRecord;

	static function __pk() {
		return ['msgid'];
	}
	static function __fields() {
		return ['add_time', 'msg', 'stream'];
	}
	protected function __get_instance() {
		return json_decode(base64_decode($this->msg), true);
	}
}
?>