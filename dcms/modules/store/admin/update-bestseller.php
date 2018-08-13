<?php
$product=D_Core_Factory::Store_Product(D::$req->int('pid'));
$product->bestseller=D::$req->int('bestseller');
$product->save();
exit;
?>