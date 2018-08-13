<?php
$vr=D::$req->textLineArray('file');
var_dump($vr);exit;
$T['file']=new File(urldecode(base64_decode(D::$req->textLine('file'))));
?>