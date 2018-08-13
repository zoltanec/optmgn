<?php
$msg = D_Core_Factory::Feedback_FeedbackMsg(D::$req->int('msgid'));
$T['msg'] = &$msg;
if ($msg->view==0){
	$msg->view=1;
	$msg->save();
}
if(!$T['msg']) {
	throw new dRuntimeException('No_SUCH_MSG');
}
$T['conf'] = D_Core_Factory::Feedback_Feedback($confid);
?>