<?php
if(!D::$user) {
	D::$Tpl->Redirect('/users/enter/');
}
try {
	$chat = D_Core_Factory::Chat(D::$req->intID('rid'));
} catch (Exception $e) {
	D::$Tpl->RedirectOrJSON('~/', array('status' => 'ERROR_NO_SUCH_CHAT_ROOM'));
}
$message = $chat->getMessage(D::$req->int('msgid'));
if(empty($message)) {
	D::$Tpl->PrintJSON(array('status' => 'ERROR_NO_SUCH_MESSAGE'));
}
if($message->uid != D::$user->uid) {
	D::$Tpl->PrintJSON(array('status' => 'ERROR_PERMISSION_DENIED'));
}
$chat->deleteMessage($message);
D::$Tpl->PrintJSON(array('status' => 'OK'));
?>