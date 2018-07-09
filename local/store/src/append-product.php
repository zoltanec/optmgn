<?php
$T['cur_category']=D::$req->textLine('param1');
$product_id = (D::$req->int('param1') != 0 ) ? D::$req->int('param1') : D::$req->int('product');
try {
	$T['prod'] = D_Core_Factory::Store_Product($product_id);
} catch (Exception $e) {
	D::$tpl->PrintText('NO_SUCH_PRODUCT');
}
D::$tpl->title = $T['prod']->title;
D::$tpl->description = $T['prod']->descr;
?>