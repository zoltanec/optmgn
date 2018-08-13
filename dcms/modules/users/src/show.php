<?php
//загружаем информацию о пользователе
try {
	$uid = (D::$req->int('uid') != 0 ) ? D::$req->int('uid') : D::$req->intID('param1');
	$user = D_Core_Factory::Users_User($uid);
} catch (Exception $e) {
	D::$Tpl->show('user-not-found');
}
$T['siteuser'] = &$user;
?>