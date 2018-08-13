<?php
try {
	$comment = D_Core_Factory::Comments_Comment(D::$req->int('comid'));
} catch (Exception $e) {
	D::$Tpl->RedirectOrJSON('~/',array('ERROR_NO_SUCH_COMMENT'));
}
if(!D::$user) {
	D::$Tpl->RedirectOrJSON('/users/enter/',array('ERROR_UNAUTH'));
}
if(!D::$user->reqRights('delete/comments/comment/')) {
	D::$Tpl->RedirectOrJSON('~/', array('status' => 'ERROR_ACCESS_DENIED'));
}
$comment->delete();
D::$Tpl->RedirectOrJSON('~/', array('status' => 'OK'));
?>