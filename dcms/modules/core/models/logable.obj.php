<?php
trait Core_LogAble {
	function log($msg) {
		D::$db->exec("INSERT INTO #PX#_core_events ( object_hash, '{$msg}') VALUES ('".$this->object_hash."', '{$msg}')");
	}
}
?>