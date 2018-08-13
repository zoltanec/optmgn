<?php
$fileid = D::$req->textID('fileid');
$dirid = D::$req->textID('dirid');
$mode = D::$req->select('mode' , array('up', 'down'));
$file = D_Core_Factory::Media_File($fileid.':::'.$dirid);
if(!$file) {
	D::$Tpl->redirect('~/');
}
$pr=$file->UpdatePriority($mode);
echo $pr;
exit;
?>