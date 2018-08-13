<?php
$msg_code = D::$req->textLine('msg_code');
$lang = D::$req->textID('lang');
//добавляем сообщение
D::$db->exec("INSERT IGNORE INTO #PX#_lng_messages (msg_code,lang) VALUES ('{$msg_code}', '{$lang}')");
D::$Tpl->redirect('~/languages-codes/#'.$msg_code);
?>
