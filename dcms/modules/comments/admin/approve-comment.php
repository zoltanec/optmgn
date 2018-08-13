<?php
try {
	$comment = dFactory::dComment(D::$req->int('comid'));
} catch(Exception $e) {
	D::$Tpl->Redirect('~/');
}
$comment->approved(1)->save();
D::$Tpl->RedirectOrJSON('~/list-comments/', array('status' => 'OK'));
?>