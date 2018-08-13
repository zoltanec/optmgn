<?php
if( ! ( D::$user && D::$user->reqRights('user:users/*/warnings-control')) ) {
	D::$Tpl->RedirectOrJSON('~/enter/', array('status' => 'ERROR_UNAUTH'));
}
// идентификатор пользователя
try {
	$user = dFactory::dUser(D::$req->int('uid'));
} catch (Exception $e) {
	D::$Tpl->RedirectOrJSON('~/', array('ERROR_NO_SUCH_USER'));
}
$wid = $user->addUserWarning(D::$req->textLine('msg'));
$warn = $user->getUserWarning($wid);
$warn['status'] = 'OK';
D::$Tpl->PrintJSON($warn);
?>