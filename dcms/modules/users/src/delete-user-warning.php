<?php
if(!D::$user) {
	D::$Tpl->RedirectOrJSON('~/enter/', array('status' => 'ERROR_UNAUTH'));
}
$uid = D::$req->int('uid');
if( !( D::$user->uid == $uid || D::$user->reqRights('users:user/*/warnings-control') ) ) {
	D::$Tpl->RedirectOrJSON('~/enter/', array('status' => 'ERROR_DENIED'));
}
// идентификатор пользователя
try {
	$user = dFactory::dUser(D::$req->int('uid'));
} catch (Exception $e) {
	D::$Tpl->PrintText('NO_SUCH_USER');
}
$user->deleteUserWarning(D::$req->int('wid'));
D::$Tpl->PrintText('OK');
?>