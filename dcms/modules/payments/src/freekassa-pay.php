<?php
try {
	$order = D_Core_Factory::Payments_Orders(D::$req->int('param1'));
} catch (Exception $e) {
	D::$tpl->PrintText('NO_SUCH_ORDER');
}

$T['order'] = &$order;


$T['signature'] = md5(implode(':', [D::$config->{'payments.freekassa.merchant_id'}, $order->sum, D::$config->{'payments.freekassa.secret1'}, $order_id]));

$T['order_id'] = $order_id;
D::$tpl->setClearRendering();