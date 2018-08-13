<?php
echo "<pre>";
header("Content-type: text/html; charset=UTF-8");

exit;
$base_lang = D::$req->textID('base');
$trgt_lang = D::$req->textID('trgt');

$messages = Core_I18n_Message::getUntranslatedList($base_lang, $trgt_lang);
foreach($messages AS $msg) {
	if( str_word_count($msg->base_msg_text) > 2 ) {
		continue;
	}
	try {
		$new = Core_I18n_MyMemory::getTranslation($msg->base_msg_text, $base_lang, $trgt_lang);
	} catch (Exception $e) {
		continue;
	}

	echo "{$new}\n{$msg->base_msg_text}\n\n\n";

	//echo "{$bsg->msg_code}>\n$msg->base_msg_text."\n";
}
echo "OK";
exit;