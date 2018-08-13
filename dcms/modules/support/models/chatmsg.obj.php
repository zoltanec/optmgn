<?php
class Support_ChatMsg extends D_Core_Object {
	use D_Db_ActiveRecord;

	public $msgid = 0;
	public $add_time = 0;
	public $upd_time = 0;
	public $stream = '';
	public $msg = '';
	public $client = '';
	public $type = 'in';
	public $ip = '';

	static protected function __pk() {
		return ['msgid'];
	}

	static protected function __fields() {
		return ['add_time','upd_time', 'client', 'type', 'stream', 'msg','ip'];
	}

	static function sendIn($client, $msg, $stream = 'WEB', $ip = NULL) {
		$m = new self();
		$m->client = $client;
		$m->msg = $msg;
		$m->type = 'in';
		$m->stream = $stream;
		$m->ip = ($ip == NULL ) ? D::$req->getIP() : $ip;
		$m->save();
	}

	static function sendOut($client, $msg, $stream = 'WEB', $ip = NULL) {
		$m = new self();
		$m->client = $client;
		$m->msg = $msg;
		$m->type = 'out';
		$m->stream = $stream;
		$m->ip = '127.0.0.1';
		$m->save();
		return true;
	}

	static function readOut($client) {
		return self::find(['client' => $client, 'type' => 'out']);
	}
}
?>