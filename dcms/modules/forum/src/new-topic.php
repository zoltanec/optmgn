<?php
$section = dObject::ForumSection(D::$req->int('sid'));
$T['section'] = &$section;
if(!D::$user or !$section or $section->readonly) {
	D::$Tpl->redirect('~/');
}
?>