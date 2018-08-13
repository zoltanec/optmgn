<?php
$user = dObject::dUser(D::$req->intID('uid'));
if(!$user) {
	D::$Tpl->Redirect('~/');
}
$active = D::$req->select('active', array('2','1'));
if(!D::$user->reqRights('update/users/duser/')) {
	D::$Tpl->Redirect('~/show/uid_'.$user->uid);
}
$user->active = $active;
$user->save();
D::$Tpl->Redirect('~/show/uid_'.$user->uid);
?>