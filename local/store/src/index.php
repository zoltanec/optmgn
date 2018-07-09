<?php
$products=Store_Product::getProductsByCategory(0,true);
$T['products']=Store_Product::sortByFields($products, array('hit'=>'1'));
?> 
