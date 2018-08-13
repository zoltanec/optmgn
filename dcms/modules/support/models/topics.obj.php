<?php
class Support_Topics extends D_Core_Object {
	use D_Db_ActiveRecord;

	public $tid = 0;
	public $dept = 0;
	public $subject = '';
	public $author = '';
	public $code = '';
	public $add_time = 0;
	public $upd_time = 0;

	static protected function __pk() {
		return ['tid'];
	}
	static protected function __fields() {
		return ['subject','dept','author', 'code', 'account', 'active','add_time','upd_time'];
	}

	protected function __get_messages() {
		return Support_Messages::find(['tid' => $this->tid]);
	}

	protected function __last_poster() {

	}
}
