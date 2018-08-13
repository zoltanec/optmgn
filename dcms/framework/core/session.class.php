<?php
class D_Core_Session implements ArrayAccess {

	function offsetExists($name) {
		if(!isset($_SESSION)) session_start();

		return isset($_SESSION[$name]);
	}

	function offsetGet($name) {
		if(!isset($_SESSION)) session_start();

		if(!isset($_SESSION[$name])) return NULL;

		return $_SESSION[$name];
	}

	function offsetSet($name, $value) {
		if(!isset($_SESSION)) session_start();

		$_SESSION[$name] = $value;
	}
	function offsetUnset($name) {
		if(!isset($_SESSION)) session_start();

		unset($_SESSION[$name]);
	}

	function id() {
		return session_id();
	}
}
?>