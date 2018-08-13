<?php
if(!D::$user) {
	D::$Tpl->RedirectOrText('~/', 'UNAUTH');
}
$redirectUrl = D::$req->url('redirecturl');
$comid = D::$req->int('comid');
try {
	$comment = D_Core_Factory::Comments_Comment(D::$req->int('comid'));
} catch (Exception $e) {
	D::$Tpl->Redirect('~/');
}
if(!$comment) {
	D::$Tpl->Redirect($redirectUrl);
}
if($comment->uid != D::$user->uid AND !D::$user->reqRights('edit/comments/dcomment/')) {
	D::$Tpl->Redirect($redirectUrl);
}
$T['comment'] = &$comment;
if(D::$req->isAjax()) {
	D::$Tpl->RenderTpl('edit-comment-ajax');
}
?>