<?php
$product = new Store_Product();
$product->prod_name = 'NEW_PRODUCT';

if(D::$req->int('catid') != 0) {
	try {
		$category = D_Core_Factory::Store_Category(D::$req->int('catid'));
		$product->category_id = $category->category_id;
	} catch (Exception $e) {
		;
	}
}
$product->save();

$dir = D_Core_Factory::Media_Dir("product".$product->prod_id, Media_Dir::CREATE);

D::$Tpl->redirect('~/edit-product/pid_'.$product->prod_id);
?>