<?php
if(!D::$user) {
	D::$Tpl->redirect('~/');
}
try {
	$chat = D_Core_Factory::Chat(D::$req->intID('rid'));
} catch (Exception $e) {
	D::$Tpl->RedirectOrJSON('~/', array('status' => 'ERROR_NO_SUCH_CHAT_ROOM'));
}
$chat->user_exit(D::$user);
D::$Tpl->Redirect('/');
?>