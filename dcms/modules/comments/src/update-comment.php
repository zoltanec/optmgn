<?php
$redirectUrl = D::$req->url('referer');
try {
	$comment = D_Core_Factory::Comments_Comment(D::$req->int('comid'));
} catch (Exception $e) {
	if(D::$req->isAjax()) {
		D::$Tpl->PrintText('NO_SUCH_COMMENT');
	} else {
		D::$Tpl->Redirect($redirectUrl);
	}
}
if($comment->uid != D::$user->uid and !D::$user->reqRights('update/comments/dcomment/')) {
	if(D::$req->isAjax()) {
		D::$Tpl->PrintText('PERMISSION_DENIED');
	} else {
		D::$Tpl->Redirect($redirectUrl);
	}
}
$moderator_note = D::$req->html('moderator_note');

if($comment->uid != D::$user->uid and $moderator_note ) {
	$comment->moderator_note = $moderator_note;
}
$content = D::$req->bbText('content');
if($content != '') {
	$comment->content = $content;
	$comment->save();
}
// rendering template
if(D::$req->isAjax()) {
	D::$Tpl->PrintText($comment->html);
} else {
	D::$Tpl->Redirect($redirectUrl.'#'.$comment->comid);
}
?>