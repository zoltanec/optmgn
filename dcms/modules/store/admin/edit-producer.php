<?php
$producer=D_Core_Factory::Store_Producer(D::$req->int('pid'));
if(!$producer) {
	throw new dRuntimeException('NO SUCH PRODUCER');
}
$T['producer']=$producer;
?>