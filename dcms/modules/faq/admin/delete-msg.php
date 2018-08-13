<?php
$msg = D_Core_Factory::FeedbackMsg(D::$req->int('msgid'));
if(!$msg) {
	throw new dRuntimeException('No_SUCH_MSG');
}
$msg->delete();
D::$Tpl->Redirect(D::$req->referer());
?>