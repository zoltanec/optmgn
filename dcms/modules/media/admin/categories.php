<?php
$dirid=D::$req->textID('dir');
if(!$dirid)
	$dirid="root";
$dir = D_Core_Factory::Media_Dir($dirid);
$T['current_dir'] = &$dir;
?>