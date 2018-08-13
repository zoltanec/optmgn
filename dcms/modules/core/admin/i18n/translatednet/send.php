<?php
$api = new Core_I18n_TranslatedNet();
//$api->langs();exit;


$msg = 'Для вашей безопасности мы используем проверенные годами решения на базе технологий OpenVPN и PPtP. Это позволяет защитить ваши данные от любых известных на данный момент способов перехвата информации.';
$lang_from = 'ru';
$lang_to   = 'es';

$quote = $api->quote($msg, $lang_from, $lang_to);

$p = new Core_I18n_Project();
$p->lang_from = $lang_from;
$p->lang_to = $lang_to;
$p->source = $msg;
$p->export = md5('TRANSLATEDNET'.$quote['pid']);
$p->price = $quote['price'];
$p->save();

var_dump($p);

var_dump($quote);
//$api->approve($quote['pid']);
exit;