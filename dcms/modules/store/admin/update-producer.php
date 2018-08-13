<?php
$producer=D_Core_Factory::Store_Producer(D::$req->int('pid'));
if(!$producer) {
	throw new dRuntimeException('NO SUCH PRODUCER');
}
D::$req->map($producer, array('producer_name'=>'textLine','country_id'=>'int','descr'=>'textLine'));
$producer->save();
D::$Tpl->redirect('~/producers');
?>