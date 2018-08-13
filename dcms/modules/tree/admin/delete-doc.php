<?php
$doc = dObject::Tree(D::$req->int('did'));
if(!$doc) {
	throw new dRuntimeException('No_SUCH_DOC');
}
$doc->Delete();
//header("location:".D::$req->Referer());
D::$Tpl->Redirect('~/');
//D::$Tpl->RenderTpl('tree;admin/add-doc.tpl');
?>