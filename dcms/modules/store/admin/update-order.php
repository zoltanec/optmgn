<?php
$order = D_Core_Factory::Store_Cart(D::$req->int('ordid'));
if(D::$req->mode == 'status') {
	$status = D::$req->int('status');
	$order->status = $status;
	$order->setOrderStatus($status);
} else {
	$order->order_name = D::$req->textLine('order_name');
	$order->order_phone = D::$req->textLine('order_phone');
	$order->order_address = D::$req->textLine('order_address');
	$order->payment = D::$req->select('payment', array_keys(Store_Cart::getPaymentModes()));
	$order->delivery = (D::$req->int('nodelivery') == 0 ? 1 : 0);
	$order->delivery_payment = D::$req->int('delivery_payment');
	$order->description = D::$req->textLine('description');
	$order->discount=D::$req->float('discount');
	$order->save();
}
$order->save();
D::$tpl->Redirect(D::$req->getReferer());
?>