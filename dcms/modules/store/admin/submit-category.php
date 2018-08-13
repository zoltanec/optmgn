<?php
$category=new Store_Category();
if(!$category) {
	throw new dRuntimeException('NO SUCH OBJECT');
}
$category->category_name=D::$req->textLine('category_name');
$category->category_pid=D::$req->int('category_pid');
$logo=D::$req->image('category_logo');
if($logo){
	$filename=substr(md5($category->category_id.'/'.rand(0,100000)),0,6);
	$logo->resize(200,200);
	$logo->save(D::$content_path.'/store/'.$filename.'.png','png');
	$category->category_logo=$filename.'.png';
}
	$category->save();
D::$Tpl->redirect(D::$req->referer());
?>