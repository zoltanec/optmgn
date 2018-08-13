<?php
if(!D::$user) {
	D::$Tpl->PrintJSON(array('status' => 'ERROR_UNAUTH'));
}
$messages = Users_PrivateMessage::__getLastMessages(D::$user->uid,D::$req->intID('last_msgid'));
foreach($messages AS &$msg) {
	$msg['content'] = addslashes(strip_tags($msg['content']));
}
// теперь нам необходимо удали
D::$Tpl->PrintJSON($messages);
?>