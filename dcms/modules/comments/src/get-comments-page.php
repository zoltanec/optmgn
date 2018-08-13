<?php
$object_id = D::$req->textLine('object_id');
$comid = D::$req->intID('comid');
$page = D::$req->page('cmpage');
$perpage = D::$req->int('cmperpage');
$order_mode = D::$req->select('order_mode', array('normal', 'reverse'));
//$order = D::$req->select('m')
$T['comments'] = D_Core_Factory::Comments_List($object_id, $page, $perpage, $order_mode);
if(D::$req->textLine('showmode') == 'only-comments') {
	D::$Tpl->RenderTpl('get-latest-comments');
}
//var_dump($T['comments']);exit;
//$T['comments_meta'] = dObject::dCommentsMeta(md5(strtolower($object_id)));
?>