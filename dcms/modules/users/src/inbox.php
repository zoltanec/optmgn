<?php
if(!D::$user) {
	D::$Tpl->redirect('~/enter/');
}
$T['box'] = new PrivateMailBox(D::$user->uid);
?>