<?php
$code = D::$req->textID('code');
if(!empty($code)) {
	$T['msgs'] = D::$db->fetchlines("SELECT * FROM #PX#_lng_messages WHERE msg_code = '{$code}'");
	D::$Tpl->RenderTpl('edit-language-code');
} else {
	D::$Tpl->PrintText('');
}
?>