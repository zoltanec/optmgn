<?php
$section = dObject::ForumSection(D::$req->int('sid'));
if($section) {
	$cid = D::$req->intID('cid');
	if(D::$req->flag('update')) {
		$section->updateCategory($cid, D::$req->textLine('name'));
	} else {
		$section->deleteCategory($cid);
	}
	D::$Tpl->redirect('~/edit-section/sid_'.$section->sid.'/');
} else D::$Tpl->redirect('~/');
?>