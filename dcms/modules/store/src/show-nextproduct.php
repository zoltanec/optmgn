<?php
$T['cur_category']=$category_code=D::$req->textLine('param1');
$mode=D::$req->textLine('mode');
$categories=Store_Category::getChildCategories($category_code);
foreach($categories as $category){
	$cond="category_id=".$category->category_id;
	foreach(Store_Product::getBySearchCond($cond)->fetchPage() as $prod){
		$prods[]=$prod;
	}
}
foreach($prods as $prod){
	if($prod->prod_id==D::$req->int("product"))
		$current=array_search($prod,$prods);
}
if($mode=='next'){
	if($current==count($prods)-1)
		$current=0;
	else $current++;
}else {
	if($current==0)
		$current=count($prods)-1;
	else $current--;
}
$T['prod']=$prods[$current];
D::$Tpl->renderTpl('store;product');
exit;
?>