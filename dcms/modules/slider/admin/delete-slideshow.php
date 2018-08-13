<?php
$ssid = D::$req->int('ssid');
$slideshow = D_Core_Factory::Slider_Slideshow($ssid);
if(!$slideshow) {
	D::$Tpl->Redirect('~/');
}
$slideshow->delete();
if(D::$req->isAjax())
	D::$Tpl->PrintJSON(array('result' => 'OK'));
else
	D::$Tpl->Redirect('~/');
?>