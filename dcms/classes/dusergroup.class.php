<?php
class dUserGroup extends dObject {
	static function __fetch($id) {
		return false;
	}

	function object_id() {
		return 'core-dusergroup-'.$this->gid;
	}

	protected function __save() {
		return 0;
	}

	static function listGroups() {
		return D::$db->fetchobjects("SELECT * FROM #PX#_acl_groups",__CLASS__);
	}
}
?>