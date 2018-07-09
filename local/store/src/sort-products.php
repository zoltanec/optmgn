<?php
$category_code=D::$req->textLine('category');
//Получение категории
$T['category'] = D_Core_Factory::Store_Category($category_code);
if($T['category']->category_pid!=0)
	$T['parent_category'] = $T['category']->parent;
else $T['parent_category'] = $T['category'];
//Получение продуктов
$prods=array();
foreach(Store_Category::getChildCategories($category_code) as $category){
	foreach(Store_Product::getBySearchCond("category_id={$category->category_id}") as $product){
		$prods[]=$product;
	}
}
$T['sorting']=array();
if(D::$req->int('vega'))
	$T['sorting']['vega']=1;
if(D::$req->int('without_fish'))
	$T['sorting']['without_fish']=1;
//Сортировка по дополнительным полям
D::$tpl->title = $T['parent_category']->name;
D::$tpl->description = $T['parent_category']->descr;
?>
