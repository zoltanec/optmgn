<?php
	$quantity = D::$req->int('quantity');
	$ordid = D::$req->int('ordid');
	
	if($quantity == 0) $quantity = 1;
	$prod_id = D::$req->int('product');
	try{
		$prod = D_Core_Factory::Store_Product($prod_id);
	}catch (D_Core_Exception $e) {
		$e->RenderTrace();
	}
	$hash = $prod->prod_id.".".md5(print_r('',true));
	$item = new Store_CartItem();
	$item->pack_id(1)->order_id($ordid)->hash($hash)->quantity($quantity)->prod_id($prod->prod_id)->price($prod->current_price);
	$item->save();
	D::$tpl->redirect(D::$req->referer());
?>