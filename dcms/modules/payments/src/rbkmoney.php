<?php
$variables = ['eshopId', 'recipientAmount', 'recipientCurrency', 'user_email', 'serviceName', 'orderId', 'userFields'];
$data = [];
foreach($variables AS $var) {
	$data[] = D::$req->raw($var);
}
$data[] = D::$config->{'payments.rbk.secret'};

$req_hash = md5(implode('::', $data));
$hash = D::$req->textLine('hash');

if($hash != $req_hash) {
	D::$tpl->PrintText('WRONG_HASH');
}

$order_id = D::$req->int('orderId');
try {
	$order = D_Core_Factory::Payments_Orders($order_id);
} catch (Exception $e) {
	D::$tpl->PrintText('NOORDER');
}

if( $order->status != Payments_Orders::S_UNPAID) {
	D::$tpl->PrintText('WRONGSTAT');
}
D::$tpl->PrintText('OK');
/**

$mrh_pass2 = D::$config->{'payments.robokassa.password2'};
$sum = D::$req->raw('OutSum');
$checkHash = D::$req->textLine('SignatureValue');
$method = D::$req->textLine('PaymentMethod');
$label = D::$req->textLine('IncCurrLabel');

$crc2 = md5(implode(':', array($sum, $invId, $mrh_pass2)));

if( strtolower($checkHash) != $crc2 ) {
	$order->status = Payments_Orders::S_ERROR;
	$order->save();
	D::$tpl->PrintText('BAD');
}
$order->upd_time = time();
$order->setStatus(Payments_Orders::S_PAID);
$order->save();

D::$tpl->PrintText('OK');
*/