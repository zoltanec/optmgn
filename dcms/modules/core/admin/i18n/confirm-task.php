<?php
$codes = $_REQUEST['codes'];
$from = D::$req->textID('from');
$to   = D::$req->textID('to');

$task = "";
foreach($codes AS $code) {
	$task .= "\n@".$code."\n";
	$task .= D_Core_I18n::translate($code, $from);
}

if(D::$req->flag('preview')) {
	D::$tpl->setContentType('text/plain');
	D::$tpl->PrintText($task);
}
if(D::$req->flag('submit')) {

	$api = new Core_I18n_TranslatedNet();
	$quote = $api->quote($task, $from, $to);

	$p = new Core_I18n_Project();
	$p->lang_from = $from;
	$p->lang_to = $to;
	$p->source = $task;
	$p->code = "TRANSLATION_BLOCK";

	$p->export = md5('TRANSLATEDNET'.$quote['pid']);
	$p->price = $quote['price'];
	$p->save();

	$api->approve($quote['pid']);

	D::$tpl->PrintText("Order approved. Price {$quote['price']} EUR");
}
