<?php
if(!D::$user) {
	D::$tpl->PrintText('NO_SUCH_USER');
}
$T['orders'] = [];
$T['orders']['active'] = Store_Cart::find(['uid' => D::$user->uid, 'status' => ['!=', 5]]);
$T['orders']['old'] = Store_Cart::find(['uid' => D::$user->uid, 'status' => 5], ['limit' => 10]);
?>