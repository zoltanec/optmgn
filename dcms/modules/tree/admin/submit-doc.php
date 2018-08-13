<?php
$doc = new Tree();
if(!$doc) {
	throw new dRuntimeException('NO_SUCH_RESORT');
}
D::$req->map($doc,array('dname'=>'textLine','dcontent'=>'raw','pid'=>'int', 'priority'=>'int'));

//$doc->pid=0;
$doc->save();
D::$Tpl->Redirect(D::$req->getReferer());
?>