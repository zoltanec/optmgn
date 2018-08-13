<?php
try {
	$parent = D_Core_Factory::Store_Category(D::$req->int('catid'));
	$category_pid = $parent->category_id;
} catch (Exception $e ) {
	$category_pid = 0;
}
$category = new Store_Category();
$category->category_name = D::$req->textLine('category_name');
$category->category_pid = $category_pid;
$category->save();
D::$tpl->Redirect('~/edit-category/catid_'.$category->category_id);
?>