<?php
try {
	$user = D_Core_Factory::Users_User(D::$req->intID('uid'));
} catch(Exception $e) {
	D::$tpl->Redirect('~/index/');
}
D::$req->map($user, array('username' => 'textLine', 'about' => 'bbText', 'active' => 'bool', 'gid' => 'intID', 'sign' => 'textLine'));

if(D::$req->raw('password') != '') {
	$user->setPassword(D::$req->raw('password'));
}
$user->save();
D::$tpl->Redirect('~/edit-user/uid_'.$user->uid);
?>