<?php
$section = dObject::ForumSection(D::$req->int('sid'));
if($section) {
	$section->addCategory(D::$req->textLine('name'));
	D::$Tpl->redirect('~/edit-section/sid_'.$section->sid.'/');
} else D::$Tpl->redirect('~/');
?>