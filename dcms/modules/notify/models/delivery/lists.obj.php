<?php
class Notify_Delivery_Lists extends D_Core_Object {
	use D_Db_ActiveRecord;

	public $lid = 0;
	public $add_time = 0;
	public $name = '';

	static function __pk() {
		return ['lid'];
	}

	static function __fields() {
		return ['add_time','name'];
	}

	public function loadFromFile($file) {
		if(!file_exists($file)) {
			throw new D_Core_Exception('No such list file:'.$file);
		}
		$data = file_get_contents($file);
		$query = [];
		foreach(explode("\n", $data) AS $number) {
			$query[] = "(UNIX_TIMESTAMP(), '{$this->lid}','".addslashes($number)."')";
		}
		if(sizeof($query) > 0 ) {
			D::$db->exec("INSERT IGNORE INTO #PX#_notify_delivery_listitems (add_time, lid, address) VALUES ".implode(',', $query));
		}
		return ['total' => sizeof($query)];
	}

	public function __get_count() {
		return D::$db->fetchvar("SELECT COUNT(1) FROM #PX#_notify_delivery_listitems WHERE lid = '{$this->lid}'");
	}

}
?>