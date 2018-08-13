<?php
try {
	$object = D_Core_Factory::getByID(D::$req->textLine('object_id'));
} catch ( Exception $e ) {
	D::$tpl->PrintJSON(array('status' => 'OK' ));
}
$flag = D::$req->bool('active');
$object->active = $flag;
$object->save();
D::$tpl->PrintJSON(array('status' => 'OK' ));
?>