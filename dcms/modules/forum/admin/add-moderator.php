<?php
$section = dObject::ForumSection(D::$req->intID('sid'));
if(!$section) {
	D::$Tpl->Redirect('~/');
}
$user = dUser::getByUsername(D::$req->textLine('username'));
if(!$user) {
	D::$Tpl->Redirect('~/edit-section/sid_'.$section->sid);
}
$section->AddModerator($user->uid);
D::$Tpl->Redirect('~/edit-section/sid_'.$section->sid);
?>