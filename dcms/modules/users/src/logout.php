<?php
if(D::$user) {
	D::$user->logout();
}
D::$Tpl->RedirectOrJSON("/", array('status' => 'OK'));
?>