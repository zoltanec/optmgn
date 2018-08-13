<?php
header("Content-type: text/plain; charset=UTF-8");
$lang = D::$req->textID('lang');
$messages = D::$db->fetchlines("SELECT * FROM #PX#_core_messages WHERE lang = '{$lang}'");
echo "@@".$lang."\n";
foreach($messages AS $message) {
	if($message['msg_text'] == $message['msg_code']) continue;

	if(isset($message['javascript']) and $message['javascript']) {
		echo "\n@~";
	}else {
		echo "\n@";
	}
	echo $message['msg_code']."\n";
	echo $message['msg_text']."\n";
}
exit;
?>