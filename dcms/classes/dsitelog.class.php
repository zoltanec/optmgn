<?php
define('EVENT_ADD',1);
define('EVENT_DELETE',2);
define('EVENT_UPDATE', 3);
define('EVENT_OTHER', 4);
class dSiteLog {
	static function Append($action_type, $object_id = '', $message = '') {

	}
	/**
	 * Dump data
	 *
	 * @param unknown_type $text
	 */
	static function Dump($text) {
		file_put_contents(D::$path.'/dump/'.md5(rand()), $text);
	}
}
/**
 * Some choto tam
 */
/**
 * Haha blin
 */
?>