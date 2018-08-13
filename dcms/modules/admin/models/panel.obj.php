<?php
class Admin_Panel {

	static function getAdminPanel() {
		if(!D::$user || !D::$user->hasRight('admin://panel/show')) return;

		return D::$tpl->fetch('admin;admin-panel');
	}

}
?>