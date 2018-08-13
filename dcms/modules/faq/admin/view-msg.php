<?php
$msg = D_Core_Factory::FeedbackMsg(D::$req->int('msgid'));
$T['msg'] = &$msg;
if ($msg->view==0){
	$msg->view=1;
	$msg->save();
}
if(!$T['msg']) {
	throw new dRuntimeException('No_SUCH_MSG');
}
$T['conf'] = dObject::Feedback($confid);
?>