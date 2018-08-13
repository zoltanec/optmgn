<?php
$filename=D::$req->textLine('filename');
$file=new File(D::$req->textLine('file'));
$owner=implode('', D::$req->intArray('owner'));
$group=implode('', D::$req->intArray('group'));
$all=implode('', D::$req->intArray('all'));
$owner=base_convert($owner,2,8);
$group=base_convert($group,2,8);
$all=base_convert($all,2,8);
$perms=implode('',array($owner,$group,$all));
chmod($file->pwd, intval($perms,8));
rename($file->pwd,$file->filepath.$filename);
D::$Tpl->Redirect('~/cd-dir/currentdir_'.base64_encode(urlencode($file->filepath)));
?>