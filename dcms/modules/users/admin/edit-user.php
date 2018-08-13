<?php
$uid = D::$req->int('uid');
try {
	$user = D_Core_Factory::Users_User($uid);
} catch (Exception $e) {
	D::$Tpl->Redirect('~/');
}
$T['siteuser'] = &$user;
?>