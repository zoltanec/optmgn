<?php
if(!D::$user) {
	D::$Tpl->RedirectOrJSON('~/enter/', array('status' => 'ERROR_UNAUTH'));
}
$uid = D::$req->int('uid');
if( !( D::$user->uid == $uid || D::$user->reqRights('users:user/*/warnings-control') ) ) {
	D::$Tpl->RedirectOrJSON('~/enter/', array('status' => 'ERROR_DENIED'));
}

// загружаем предупреждения выданные пользователю
try {
	$user = dFactory::dUser($uid);
} catch (Exception $e) {
	D::$Tpl->PrintJSON(array('status' => 'ERROR_NO_SUCH_USER'));
}
// получаем список предупреждений к пользователю
D::$Tpl->PrintJSON($user->getUserWarningsList());
?>