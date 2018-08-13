<?php
$dirname=D::$req->textLine('file');
$currentdir=D::$req->textLine('dir');
mkdir($currentdir.'/'.$dirname);
$T['dir']=new File($currentdir);
D::$Tpl->RenderTpl('filemanager;admin/list.tpl');
?>