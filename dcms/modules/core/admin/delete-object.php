<?php
try { 
	$object = D_Core_Factory::getByID(D::$req->textLine('object_id'));
} catch (Exception $e) {
	D::$tpl->PrintJSON(array('status' => 'NO_SUCH_OBJECT'));
}
$object->delete();
D::$tpl->PrintJSON(array('status' => 'OK' ));
?>