<?php
if(!D::$user) {
	D::$Tpl->RedirectOrText('~/enter/','ERROR_UNAUTH');
}

try {
	$message = D_Core_Factory::Users_Private_Messages(D::$req->int('msgid'));
} catch (Exception $e) {
	D::$Tpl->RedirectOrText('~/my-chats/','ERROR_NO_SUCM_PM');
}

try {
	$chatA = D_Core_Factory::Users_Private_Chats($message->chatid_A);
} catch (Exception $e) {
	D::$Tpl->RedirectOrText('~/my-chats/');
}

// идентификатор чата
$chatid = ($chatA->owner == D::$user->uid) ? $chatA->chatid : $message->chatid_B;

try {
	$chat = D_Core_Factory::Users_Private_Chats($chatid);
} catch (Exception $e) {
	D::$Tpl->RedirectOrText('~/my-chats/','ERROR_NO_SUCH_PM_CHAT');
}

// теперь проверяем права
if(!$chat->inChat(D::$user->uid)) {
	D::$Tpl->RedirectOrText('~/my-chats/','ERROR_NOT_IN_PM_CHAT');
}

$message->deleteForChat($chat->chatid);

if($message->active_flag == 0) {
	$message->delete();
} else {
	$message->save();
}

$chat->messages--;
$chat->save();
D::$Tpl->PrintText('OK');
?>