<?php
//echo "EXIT";
//$sms_id = '13-2546728';
//$msg = Notify_Delivery_Messages::find(['id' => $sms_id ],['limit' => 1]);
//var_dump($msg);exit;

//D::dump(print_r($_POST,1),'sms');
if(!isset($_POST['data'])) D::$tpl->PrintText('100');

foreach ($_POST["data"] AS $entry) {
	$lines = explode("\n",$entry);
	if ($lines[0] == "sms_status") {
		$sms_id = trim($lines[1]);
		$sms_status = $lines[2];

		if($sms_status == '103') {
			$msg = Notify_Delivery_Messages::find(['id' => $sms_id ],['limit' => 1]);

			if(!is_object($msg)) continue;

			//D::dump("ERROR {$msg->address}","sms");
			//D::dump("OBJ:".print_r($msg,1),'sms');

			//D::dump(print_r($msg,1),'sms');
			$msg->status = 2;
			$msg->save();
		}
	}
}
D::$tpl->PrintText('100');