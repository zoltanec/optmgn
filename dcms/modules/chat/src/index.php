<?php
if(!D::$user) {
	D::$Tpl->Redirect('/users/enter/');
}
try {
	$chat = D_Core_Factory::Chat(D::$req->int('rim'));
} catch (Exception $e) {
	D::$Tpl->RedirectOrJSON('~/',array('status' => 'ERROR_NO_SUCH_CHAT_ROOM'));
}
$chat->enter(D::$user);
D::$Tpl->RenderTpl('chat');
?>