<?php
try {
	$object = D_Core_Factory::getByID(D::$req->textLine('object_id'));
} catch (Exception $e) {
	D::$tpl->PrintJSON(array('status' => 'NO_SUCH_OBJECT'));
}
$field = D::$req->textID('field');
if(!isset($object->{$field})) {
	D::$tpl->PrintJSON(array('status' => 'NO_SUCH_FIELD'));
}
$mode  = D::$req->textID('mode');
switch($mode) {
	case "inc":
	case "dec":
	case "upd":
		$value = 0;
		if($mode == 'inc') {
			$value = +1;
		} elseif($mode == 'dec') {
			$value = -1;
		} elseif($mode == 'upd') {
			$value = D::$req->int('value');
		}
		$object->{$field} += $value;
		break;
}
$object->save();
D::$tpl->PrintJSON(array('status' => 'OK', 'value' => $object->{$field}));