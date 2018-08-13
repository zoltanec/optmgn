<?php
if(!D::$req->textLine('param1'))
	D::$Tpl->redirect('/store');
$category_code=D::$req->textLine('param1');
$T['category'] = D_Core_Factory::Store_Category($category_code);
if($T['category']->category_pid!=0)
	$T['parent_category'] = $T['category']->parent;
else $T['parent_category'] = $T['category'];
D::$tpl->title = $T['category']->name;
D::$tpl->description = $T['category']->descr;
if($T['category']->custom_tpl) D::$tpl->show('categories/'.$T['category']->category_code);
?>
