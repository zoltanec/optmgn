<?php
$path = '/var/www/www.hideman.net/www/themes/api/templates/api/faq.tpl';

$codes = Core_I18n_File::getMessagesFromFile($path);
$T['msgs'] = [];

$from = D::$req->textID('from');
$to   = D::$req->textID('to');

foreach($codes AS $code) {
	$tr = D_Core_I18n::translate($code, $to);
	if($tr != $code) continue;

	$T['msgs'][] = ['code'=> $code, 'text' => D_Core_I18n::translate($code, $from)];
}