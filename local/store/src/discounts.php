<?php
$category_code=D::$req->textLine('param1');
if(!$category_code) {
	$T['category'] = D_Core_Factory::Store_Category(0);
	//$T['category']->category_code = 0;
}else {
	$T['category'] = D_Core_Factory::Store_Category($category_code);
}
if($T['category']->category_pid!=0)
	$T['parent_category'] = $T['category']->parent;
else $T['parent_category'] = $T['category'];
$T['search_cond']=array('price');
D::$tpl->title = $T['category']->name;
D::$tpl->description = $T['category']->descr;
?>
