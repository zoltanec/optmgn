<?php
try {
	$chat = D_Core_Factory::Chat(D::$req->rid());
} catch (Exception $e) {
	D::$Tpl->RedirectOrJSON('~/', array('status' => 'ERROR_NO_SUCH_CHAT_ROOM'));
}
$msgid = $chat->send(D::$user->uid, NULL, D::$req->textLine('msg'));
D::$Tpl->PrintJSON(array('status' => 'OK', 'msgid' => $msgid));
?>