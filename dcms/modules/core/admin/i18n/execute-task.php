<?php
$api = new Core_I18n_TranslatedNet();
$code = D::$req->textID('code');
$lang_from = D::$req->textID('from');
$lang_to   = D::$req->textID('to');

$msg = D_Core_I18n::translate($code, $lang_from);

$quote = $api->quote($msg, $lang_from, $lang_to);

$p = new Core_I18n_Project();
$p->lang_from = $lang_from;
$p->lang_to = $lang_to;
$p->source = $msg;
$p->code = D::$req->textID('code');

$p->export = md5('TRANSLATEDNET'.$quote['pid']);
$p->price = $quote['price'];
$p->save();

$api->approve($quote['pid']);

D::$tpl->PrintText('OK');

exit;