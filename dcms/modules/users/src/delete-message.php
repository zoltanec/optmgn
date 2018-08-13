<?php
$msgid = D::$req->int('msgid');
$message = dObject::PrivateMail($msgid);
if(!$message) {
	D::$Tpl->redirect('~/inbox/errmsg_no-such-message/');
}
if($message->uid_to != D::$user->uid) {
	D::$Tpl->redirect('~/inbox/errmsg_you-are-not-owner/');
}
$message->delete();
D::$Tpl->redirect('~/inbox/okmsg_message-deleted/');
?>