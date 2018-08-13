<?php
$user = D_Core_Factory::D_Core_User(D::$req->textLine('username'));
if(!$user) {
	D::$Tpl->Redirect('~/');
}
D::$Tpl->Redirect('~/edit-user/uid_'.$user->uid);
?>