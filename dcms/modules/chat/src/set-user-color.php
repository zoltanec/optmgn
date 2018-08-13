<?php
if(!D::$user) {
	D::$Tpl->Redirect('/users/enter/');
}
try {
	$chat = D_Core_Factory::Chat(D::$req->intID());
} catch (Exception $e) {
	D::$Tpl->RedirectOrJSON('~/', array('status' => 'ERROR_NO_SUCH_CHAT_ROOM'));
}
// теперь указываем цвет
$color = D::$req->select('color', array_keys($chat->getColorsList()));
$chat->setUserColor(D::$user->uid, $color);
D::$Tpl->PrintJSON(array('status' => 'OK'));
?>