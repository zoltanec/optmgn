<?php
$_REQUEST['callback_ip'] = D::$req->getIP();
Payments_Callbacks::dump('freekassa', $_REQUEST);

$merchant_id = D::$config->{'payments.freekassa.merchant_id'};
$secret2 = D::$config->{'payments.freekassa.secret2'};

$amount = D::$req->textLine('out_amount');
$order_id = D::$req->textLine('order_id');

try {
	$order = D_Core_Factory::Payments_Orders($order_id);
} catch (Exception $e) {
	D::$tpl->PrintText('NOORDER');
}

$our_sign = md5(implode(':', [$merchant_id, $amount, $secret2, $order_id]));

if($our_sign != D::$req->textLine('signature')) {
	$order->status = Payments_Orders::S_ERROR;
	$order->save();
	D::$tpl->PrintText('ERROR');
}

$order->upd_time = time();
$order->setStatus(Payments_Orders::S_PAID);
$order->save();

D::$tpl->PrintText('OK');