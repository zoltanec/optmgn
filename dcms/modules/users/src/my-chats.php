<?php
if(!D::$user) {
	D::$Tpl->Redirect('~/');
}
$list = Users_Private_Chats::getChatsList(D::$user->uid);
$T['chat_list'] = &$list;
?>