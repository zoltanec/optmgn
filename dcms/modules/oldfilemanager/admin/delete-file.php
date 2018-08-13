<?php
$files=D::$req->textLineArray('file');
$dirpath=D::$req->textLine('dir');
foreach($files AS $file) {
	$file=new File($file);
	$file->delete();
}
$T['dir']=new File($dirpath);
D::$Tpl->RenderTpl('filemanager;admin/list.tpl');
?>