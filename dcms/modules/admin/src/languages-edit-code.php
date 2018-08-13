<?php
//язык
$lang = D::$req->textID('lang');
//код языка
$msg_code = D::$req->textID('code');
//загружаем информацию о сообщении
$T['msgs'] = D::$db->fetchlines("SELECT * FROM #PX#_lng_messages WHERE msg_code = '{$msg_code}'");
?>