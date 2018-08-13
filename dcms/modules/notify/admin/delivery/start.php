<?php
// let's check if delivery ready
$delivery = D_Core_Factory::Notify_Delivery(D::$req->int('param3'));
// check if we have any messages for sending in our delivery
if ( Notify_Delivery_Messages::count(['did' => $delivery->did ]) == 0 ) {
	$delivery->buildMessages();
}
D::$tpl->Redirect('~/delivery.proceed/'.$delivery->did);
?>