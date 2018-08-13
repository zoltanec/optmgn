<?php
$doc = new Faq();
if(!$doc) {
	throw new dRuntimeException('NO_SUCH_RESORT');
}
D::$req->map($doc,array('qname'=>'textLine','qcontent'=>'raw','pid'=>'int'));

$doc->save();
D::$Tpl->Redirect(D::$req->getReferer());
?>