<?php
$prod_id = D::$req->int('product');

try {
	$product = D_Core_Factory::Store_Product($prod_id);
} catch(Exception $e) {
	D::$tpl->RedirectOrJSON('~/', array('status' => 'NO_PRODUCT'));
}
$meta='';
$price=$product->price;
$descr=$product->descr;
$quantity=D::$req->int('quantity');

if(isset(D::$session['cur_pack'])) {
	$pack_id = D::$session['cur_pack'];
} else {
	$pack_id = 1;
}

if(!$quantity) {
	$quantity=1;
}

$cart = D::$session['cart'];
$hash = $product->prod_id.".".md5(print_r($meta,true));

if(! isset($cart[$pack_id][$hash]) ) {
	$cart[$pack_id][$hash] = array( 'quantity' => 0, 'prod_id' => $prod_id, 'descr' => $descr, 'price' => $price, 'visible' => true );
}

$cart[$pack_id][$hash]['quantity'] += $quantity;

//if(isset($cart[$pack_id][md5(rand())])) {
//	$quantity += $cart[$pack_id][$prod_id]['quantity'];
//}

//$cart[$pack_id][$prod_id] = array( 'quantity' => $quantity);

D::$session['cart'] = $cart;
if(D::$req->isAjax()) {
	D::$tpl->renderTpl("store;cart");
} else {
	D::$tpl->Redirect(D::$req->referer());
}
?>