<?php
$doc = dObject::Tree(D::$req->int('did'));

if(!$doc) {
	throw new dRuntimeException('No_SUCH_RESORT');
}
$T['doc'] = &$doc;
D::$Tpl->RenderTpl('tree;admin/list-doc.tpl');
?>