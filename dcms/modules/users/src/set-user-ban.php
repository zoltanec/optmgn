<?php
if(!D::$user) {
	D::$Tpl->RedirectOrJSON('~/enter/', array('status' => 'ERROR_UNAUTH'));
}
$uid = D::$req->int('uid');
if( !D::$user->reqRights('users:user/*/warnings-control')) {
	D::$Tpl->RedirectOrJSON('~/enter/', array('status' => 'ERROR_DENIED'));
}
// загружаем пользователя
try {
	$user = dFactory::dUser(D::$req->int('uid'));
} catch(Exception $e) {
	D::$Tpl->RedirectOrJSON('~/',array('status' => 'ERROR_NO_SUCH_USER'));
}
if(D::$req->textID('mode') == 'unban') {
	$user->setUnBan();
	$user->save();
} else {
	$user->setBan(D::$req->int('block_days'));
}
D::$Tpl->PrintJSON(array('status' => 'OK'));
?>