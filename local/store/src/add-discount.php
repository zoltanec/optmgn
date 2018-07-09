<?php
	$order = D_Core_Factory::Store_Cart(D::$req->int('order_id'));
	$order->discount = D::$req->float('discount');
?>
