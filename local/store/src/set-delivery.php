<?php
$nodelivery = D::$req->int('nodelivery');
$discount = D::$req->int('discount');
Store_Cart::setDelivery($nodelivery);
Store_Cart::SetDiscount($discount);
if(D::$req->isAjax()) {
	D::$tpl->PrintJSON( [ 'status' => 'OK' ] );
}
?>