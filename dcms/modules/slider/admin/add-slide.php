<?php
//добавление слайда
$slide = new Slider_Slideshow();
D::$req->map($slide, array('title' => 'textLine', 'short' => 'textLine', 'url' => 'url','video' => 'bool'));
$slide->save();
D::$Tpl->redirect("~/");
?>