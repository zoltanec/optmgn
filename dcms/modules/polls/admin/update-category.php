<?php
try {
	$category = D_Core_Factory::Polls_Category(D::$req->int('param3'));
} catch (Exception $e) {
	D::$tpl->redirect('~/');
}
$category->name = D::$req->textLine('name');
$category->descr = D::$req->html('descr');
$category->save();
D::$tpl->redirect('~/view-categories/'.$category->poll_id);
?>