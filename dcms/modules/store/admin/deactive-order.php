<?php
$order=D_Core_Factory::Store_Cart(D::$req->int('order'));
$order->deactive();
D::$Tpl->redirect(D::$req->referer());
?>