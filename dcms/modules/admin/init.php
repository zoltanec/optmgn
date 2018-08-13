<?php
require "defaults.php";
if(D::$config->{'admin.auth_mode'} == 'site') {
	if(!D::$user or !D::$user->reqRights('*/admin/*')) {
		D::$Tpl->Redirect('/users/enter/');
	}
} else {
	$username = D_Core_Auth::requireBasicAuth(D::$config->{'admin.users'}, "Authorization required", function($password){return md5($password);});
	D::$user = new Admin_User($username);
}
D::$tpl->addBC('~/index/',D::$i18n->getTranslation('ADMIN_MODULE_NAME'));
D::setContext('admin');
//для административного модуля указываем другой шаблон
self::$tpl->mainResource = 'admin;main';