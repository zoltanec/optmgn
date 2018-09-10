<?php
$hit = [];
$new = [];
$sale = [];
$products=Store_Product::getProductsByCategory(0,true);
$T['products']=Store_Product::sortByFields($products, array('hit'=>'1'));
foreach($products as $prod){
    if(isset($prod->fields['wholesale-hit']) && $prod->fields['wholesale-hit']->content){
        $hit[] = $prod;
    }elseif(isset($prod->fields['wholesale-new']) && $prod->fields['wholesale-new']->content){
        $new[] = $prod;
    }elseif(isset($prod->fields['wholesale-sale']) && $prod->fields['wholesale-sale']->content){
        $sale[] = $prod;
    }
}
$T['hit'] = $hit;
$T['new'] = $new;
$T['sale'] = $sale;
?> 
