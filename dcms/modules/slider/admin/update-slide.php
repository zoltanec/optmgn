<?php
$ssid = D::$req->int('ssid');
//обновляем информацию о слайде
$slide = D_Core_Factory::Slider_Slideshow($ssid);
D::$req->map($slide, array('url' => 'url', 'title' => 'textLine', 'short' => 'textLine', 'active' => 'bool','sort' => 'int','video' => 'bool'));
//проверяем не была ли передана нам картинка
if(isset(D::$req->uploaded->files['image']) AND is_object(D::$req->uploaded->files['image'])) {
	$photo = new D_Files_Image(D::$req->uploaded->files['image']);
	$photo->save($run['my_content']."/slides/slidephoto".$slide->ssid.".jpg",'jpg',true);
	$slide->image = 'slidephoto'.$slide->ssid.".jpg";
}
$slide->save();
D::$Tpl->redirect("~/index/#ssid{$slide->ssid}");
?>