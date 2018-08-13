<?php
$filename=D::$req->textLine('file');
$file=new File(urldecode(base64_decode($filename)));
$file->delete();
D::$Tpl->Redirect('~/cd-dir/currentdir_'.base64_encode(urlencode($file->filepath)));
?>
