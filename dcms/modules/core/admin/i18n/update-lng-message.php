<?php
$msg_code = D::$req->textID('msg_code');
$lang = D::$req->textID('lang');
try {
	$msg = D_Core_Factory::Core_I18n_Message($msg_code, $lang);
} catch (Exception $e) {
	$msg = new Core_I18n_Message();
	$msg->msg_code = $msg_code;
	$msg->lang = $lang;
}

D::$req->map($msg, array('msg_text'=>'textLine', 'javascript' => 'bool', 'module' => 'textID'));
$msg->save();
D::$tpl->PrintJSON(array('status' => 'OK'));
?>