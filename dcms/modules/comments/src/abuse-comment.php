<?php
$moderatorsList = array(40443,68654,67306,1864,3177);
$comment = dObject::dComment(D::$req->intID('comid'));
//проверяем найден ли комментарий в базе
if(!$comment) {
	if(D::$req->isAjax()) {
		D::$Tpl->PrintText('NO_SUCH_COMMENT');
	} else {
		D::$Tpl->Redirect($url);
	}
}
$reason = D::$req->textLine('reason');
$url = D::$req->url('url');
D::appendModuleNamespace('users');
foreach($moderatorsList AS $uid) {
	PrivateMail::Send($uid, "Жалоба:".$reason,"Ссылка: {$url}#commentN{$comment->comid}. \n Редактировать: ".D::$web."/comments/edit-comment/comid_{$comment->comid}/ \n Комментарий:\n ".$comment->content);
}
D::$Tpl->PrintText('OK');
?>