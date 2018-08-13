<?php
$item = D_Core_Factory::Admin_MenuItem(D::$req->int('item_id'));

if(D::$req->textLine('save')) {
	D::$req->map($item, array('menu_name' => 'textLine'));
	$item->uri = D::$req->url('menu_uri');
	//var_dump($item);exit;
	$item->save();
} else {
	$item->delete();
}
D::$Tpl->Redirect('~/menu-items/');
?>
