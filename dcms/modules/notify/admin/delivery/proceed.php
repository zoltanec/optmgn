<?php
$delivery = D_Core_Factory::Notify_Delivery(D::$req->int('param3'));

$messages = Notify_Delivery_Messages::find(['status' => 0, 'did' => $delivery->did ],['limit' => 20]);
if(sizeof($messages) == 0 ) {
	D::$tpl->Redirect('~/delivery.index/');
}
foreach($messages AS $msg) {
	if($msg->mode == 'sms') {
		$answer = Notify_Sms::send($msg->address, $msg->msg);
		if(!isset($answer) || empty($answer)) {
			$msg->status = 3;
			$msg->save();
			continue;
		}

		list($code, $id) = explode("\n", $answer);

		if($code == '100') {
			$msg->status = 1;
			$msg->id = $id;
		} else {
			$msg->status = 3;
		}
		$msg->save();
	}
}
$T['messages'] = &$messages;
?>