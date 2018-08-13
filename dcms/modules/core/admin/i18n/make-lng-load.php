<?php
$lang = D::$req->select('lang', D::$config->languages);
$enc = D::$req->select('enc', ['none','base64']);
$content = D::$req->raw('content');
if($enc == 'base64') {
	$content = base64_decode($content);
}
$content = "@@".$lang."\n".$content;

$T['data'] = Core_I18n_File::loadI18nMessages($content);

//D::$tpl->PrintText($content);
//var_dump($content);
//var_dump($_REQUEST);
//exit;