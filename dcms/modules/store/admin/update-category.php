<?php
$category = D_Core_Factory::Store_Category(D::$req->int('catid'));

D::$req->map($category, array('category_name' => 'textLine', 'title'=>'textLine', 'keywords'=>'textLine', 'descr'=>'textLine', 'category_code' => 'textID', 'category_pid' => 'int', 'custom_tpl' => 'bool'));

$logo = D::$req->image('category_logo');
if($logo){
	$filename=substr(md5($category->category_id.'/'.rand(0,100000)),0,6);
	$logo->resize(200,200);
	$logo->save(D::$content_path.'/store/'.$filename.'.png','png');
	$category->category_logo = $filename.'.png';
}

$category->save();

D::$Tpl->redirect(D::$req->referer());
?>
