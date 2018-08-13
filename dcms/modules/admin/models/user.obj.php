<?php
class Admin_User extends D_Core_Object {
	public $username = '';

	function __construct($username) {
		$this->username = $username;
	}

	function reqRights($permission = '') {
		$perms = $this->getPermsList();

		return (sizeof($perms) > 0 && ( in_array('god', $perms) || in_array($permission, $perms)));
	}

	private function getPermsList() {
		$perms = D::$config->{'admin.permissions'};

		if(empty($perms)) return ['god'];

		if(!isset($perms[$this->username])) return [];

		return $perms[$this->username];
	}
}
?>