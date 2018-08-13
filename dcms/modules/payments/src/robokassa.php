<?php
$invId = D::$req->int('InvId');
try {
	$order = D_Core_Factory::Payments_Orders($invId);
} catch (Exception $e) {
	D::$tpl->PrintText('NOORDER');
}

if( $order->status != Payments_Orders::S_UNPAID) {
	D::$tpl->PrintText('WRONGSTAT');
}

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
?>