<?php
// если пользователь не авторизован то выкидываем его
if(!D::$user) {
	D::$Tpl->RedirectOrJSON('~/enter', array('status' => 'UNAUTH'));
}
$uid_to = D::$req->int('uid');
if($uid_to == 0) {
	D::$Tpl->RedirectOrJSON('~/my-chats/', array('status' => 'NO_SUCH_USER'));
}
Users_Private_Messages::send(D::$user->uid, D::$req->int('uid'), D::$req->bbText('content'));
D::$Tpl->RedirectOrText('~/chat/uid_'.$uid_to, 'OK');
?>