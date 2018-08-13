<?php
$name = D::$req->textID('name');
$prod_id = D::$req->int('prod_id');
try {
	$product = D_Core_Factory::Store_Product($prod_id);
} catch (Exception $e) {
	D::$tpl->PrintText('NO_SUCH_PRODUCT');
}
$list = new Store_Lists();
$list->name($name)->prod_id($prod_id)->save();
D::$tpl->Redirect('~/edit-list/name_'.$name);
?>