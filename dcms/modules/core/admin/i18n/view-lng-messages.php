<?php
// load messages which was updated on one language and compare to other language
$base_lang = D::$req->textID('base');
$target_lang = D::$req->textID('target');

$T['base_lang'] = $base_lang;
$T['target_lang'] = $target_lang;

if(empty($target_lang)) {
	$T['messages'] = Core_I18n_Message::getMessagesList($base_lang);
	$T['page_url'] = 'base_'.$base_lang."/page_!PAGE!/";
} else {
	$mode = D::$req->textID('mode');
	$T['messages'] = ($mode == 'untranslated' ) ? Core_I18n_Message::getUntranslatedList($base_lang, $target_lang) : Core_I18n_Message::getUnupdatedList($base_lang, $target_lang);
	$T['page_url'] = 'base_'.$base_lang."/target_".$target_lang."/mode_".$mode."/page_!PAGE!/";
}
if(D::$req->export == 1) {
	$T['messages']->perpage = 9999999;
	header("Content-type: text/plain; charset=UTF-8");
	$out = '';
	foreach($T['messages'] AS $msg) {
		$out.="@".$msg->msg_code."\n";
		$out.=$msg->base_msg_text."\n";
	}
	D::$tpl->PrintText($out);
} else {
	$T['messages']->perpage = 100;
	$T['messages']->page = D::$req->page('page');
}
?>