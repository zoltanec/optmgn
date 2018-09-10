<?php
$cart = Store_Cart::getCart();
D::$tpl->redirect(D::$req->referer(), ['error' => 'Ошибка']);
if(!$cart){
	$T['error'] = 'EMPTY_CART';
	D::$tpl->redirect(D::$req->referer(), ['error' => 'Корзина пуста, сначала добавьте товар в корзину!']);
} else {
	$order_phone = D::$req->textLine('order_phone');
	$order_email = D::$req->textLine('order_email');
	$order_address = D::$req->textLine('order_address');
	$order_name = D::$req->textLine('order_name');

	if(!$order_phone || !$order_email || !$order_address || !$order_names) {
		D::$tpl->redirect(D::$req->referer(), ['error' => 'Заполните все поля!']);
	}

	$order = new Store_Cart();
	D::$req->map($order,array('order_name'=>'textLine', 'order_phone'=>'textLine', 'order_address'=>'textLine', 'order_email'=>'textLine', 'description' => 'textLine'));

	$order->save();
	$order->saveItems();
}