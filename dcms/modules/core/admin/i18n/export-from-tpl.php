<?php
//$file = base64_decodestring(D::$req->textLine('file'));
$matches = [];
preg_match_all('/#([A-Z0-9\_]+)#/',file_get_contents($file),$matches );
//теперь обрабатываем найденные сообщения
$data = "";

$target = "tr";

foreach($matches[1] AS $code) {
	$target_text = D::$i18n->translate($code, $target);
	if($target_text == $code) {
		$data.= "@".$code."\n";
		$data.= D::$i18n->translate($code,'en')."\n";
	}
}
D::$tpl->PrintText($data);
