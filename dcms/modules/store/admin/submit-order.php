<?php
$order = new Store_Cart();
	$order->order_name = D::$req->textLine('order_name');
	$order->order_phone = D::$req->textLine('order_phone');
	$order->order_address = D::$req->textLine('order_address');
	$order->payment = D::$req->select('payment', array_keys(Store_Cart::getPaymentModes()));
	$delivery=D::$req->int('delivery');
	if(!$delivery)
		$delivery=1;
	$order->delivery = $delivery;

	$order->description = D::$req->textLine('description');
	$order->save();

D::$tpl->Redirect('~/edit-order/'.$order->order_id);
?>