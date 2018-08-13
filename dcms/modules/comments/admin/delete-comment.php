<?php
try {
	$comment = D_Core_Factory::Comments_Comment(D::$req->int('comid'));
} catch (Exception $e) {
	D::$Tpl->RedirectOrJSON('/', array('status' => 'ERROR_NO_SUCH_COMMENT'));
}
$comment->delete();
D::$Tpl->RedirectOrJSON("~/list-comments/");
?>