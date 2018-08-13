<?php
$langs = D::$config->languages;

$lang = D::$req->textID('target_lang');
$module = D::$req->textID('target_module');

$export = fopen(D::$config->work_dir."/".$module."-".$lang."-messages.lng", "w+");

fwrite($export,"@@".$lang."\n");

$messages = D::$db->fetchlines("SELECT * FROM #PX#_core_messages WHERE lang = '{$lang}' AND module = '{$module}'");

foreach ($messages as $msg) {
	$prefix = "@" . (( $msg['javascript'] == 1 ) ? '~' : '');

	$msg['msg_text'] = preg_replace("/([\n\r\t])/i","", $msg['msg_text']);

	fwrite($export, $prefix.$msg['msg_code']."\n");
	fwrite($export, $msg['msg_text']."\n");
}
fclose($h);
D::$tpl->RedirectOrJSON('~/', array('status' => 'OK'));
?>