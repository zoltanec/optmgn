<?php
$did=D::$req->int('did');
$T['doc']=dObject::Tree($did);
$chid=D::$req->chid;
if ($chid)
	$T['chdoc']=dObject::Tree($chid);
else $T['chdoc']=$T['doc']->getFirst();
?>