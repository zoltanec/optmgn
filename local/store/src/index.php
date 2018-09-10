<?php
$hit = [];
$new = [];
$sale = [];
$products=Store_Product::getProductsByCategory(0,true);
$T['products']=Store_Product::sortByFields($products, []);
foreach($products as $prod){
    if(isset($prod->fields['wholesale-hit']) && $prod->fields['wholesale-hit']->content){
        $hit[] = $prod;
    }
	if(isset($prod->fields['wholesale-new']) && $prod->fields['wholesale-new']->content){
        $new[] = $prod;
    }
	if(isset($prod->fields['wholesale-sale']) && $prod->fields['wholesale-sale']->content){
        $sale[] = $prod;
    }
}
$T['hit'] = $hit;
$T['new'] = $new;
$T['sale'] = $sale;
?> 
