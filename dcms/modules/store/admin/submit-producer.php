<?php
$producer=new Store_Producer();
D::$req->map($producer, array('producer_name'=>'textLine','country_id'=>'int','descr'=>'textLine'));
$producer->save();
D::$Tpl->redirect(D::$req->referer());
?>