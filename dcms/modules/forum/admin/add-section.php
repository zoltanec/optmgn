<?php
//родительский раздел
$section = dObject::ForumSection(D::$req->intID('sid'));
if($section) {
	//создаем новый разд
	$newSection = new ForumSection();
	$newSection->parent = $section->sid;
	$newSection->name = D::$req->textLine('name');
	$newSection->save();
	D::$Tpl->redirect('~/edit-section/sid_'.$section->sid.'/');
} else D::$Tpl->redirect('~/');
?>