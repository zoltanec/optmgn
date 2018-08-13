<?php
class Support_Chat_Session extends D_Core_Object {
	use D_Db_ActiveRecord;

	public $client = 'client';
	public $operator = '';
	public $upd_time = 0;

	static public $cachestatic = [ 'getActiveClients' => 60 ];

	static function __pk() {
		return ['client'];
	}

	static function __fields() {
		return ['operator','upd_time'];
	}

	static function haveActive($client) {
		$clients = self::getActiveClients();
		return in_array($client, $clients);
	}

	/**
	 Get list of active sessions
	 */
	static function __getActiveClients() {
		$sessions = self::find();
		$clients = [];
		foreach($sessions AS $s) {
			$clients[] = $s->client;
		}
		sort($clients);
		return $clients;
	}

}
?>