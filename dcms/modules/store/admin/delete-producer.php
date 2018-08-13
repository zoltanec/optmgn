<?php
$producer=D_Core_Factory::Store_Producer(D::$req->int('pid'));
if(!$producer) {
	throw new dRuntimeException('NO SUCH PRODUCER');
}
$producer->delete();
D::$Tpl->redirect(D::$req->referer());
?>