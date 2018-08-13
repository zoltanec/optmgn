<?php
$product_id = (D::$req->int('param1') != 0 ) ? D::$req->int('param1') : D::$req->int('product');
try {
	$prod = D_Core_Factory::Store_Product($product_id);
} catch (Exception $e) {
	D::$tpl->PrintText('NO_SUCH_PRODUCT');
}

if ($prod->fields['brand']->content) {
    $brand = $prod->fields['brand']->content;
} else {
    $brand = preg_replace("#(.*?)\s.*#", "$1", $prod->prod_name);
}

if ($prod->category_code == 'manfootwear') {
    $prod->prod_name = 'Кроссовки ' . $brand . ' ' . $prod->prod_name;
}

D::$tpl->title       = $prod->prod_name . ' купить за ' . $prod->price . ' руб в интернет магазине кроссовок SportLand';
D::$tpl->description = $prod->descr;

$T = array_merge($T, [
    'prod'         => $prod,
    'product'      => $prod,
    'cur_category' => D::$req->textLine('param1'),
]);    
?>