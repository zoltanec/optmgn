<?php
$doc = dObject::Tree(D::$req->int('did'));
if(!$doc) {
	throw new dRuntimeException('NO_SUCH_DOC');
}
D::$req->map($doc, array('dname' => 'textLine', 'dcontent' => 'raw', 'priority'=>'int'));
$doc->save();
D::$Tpl->Redirect(D::$req->Referer());
?>