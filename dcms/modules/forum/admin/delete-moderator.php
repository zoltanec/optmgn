<?php
$section = dObject::ForumSection(D::$req->intID('sid'));
if(!$section) {
	D::$Tpl->Redirect('~/');
}
$section->DeleteModerator(D::$req->intID('uid'));
D::$Tpl->Redirect('~/edit-section/sid_'.$section->sid);
?>