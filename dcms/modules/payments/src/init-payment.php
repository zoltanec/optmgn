<?php
$obj = D_Core_Factory::getById(D::$req->textLine('id'));
if(!$obj->isPayable()) {
	D::$tpl->RenderTpl('payment-no-available');
}
$order = new Payments_Orders();
$order->uri($obj->object_id());
$order->userdescr = $obj->code;
$order->sum = $obj->sum;
$order->save();
D::$tpl->Redirect('~/robokassa-pay/'.$order->ordid);
?>