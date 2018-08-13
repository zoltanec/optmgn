<?php
$T['section'] = dObject::ForumSection(D::$req->intID('sid'));
if(!$T['section']) {
	D::$Tpl->redirect('~/');
}
?>