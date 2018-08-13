<?php
$dirid = D::$req->textID("dir");
if(!$dirid)
	$dirid = 'root';
try{
	$T['current_dir'] = D_Core_Factory::Media_Dir($dirid);
} catch (Exception $e) {
	D::$tpl->RedirectOrJSON('~/', array('status' => 'ERROR_NOT_SUCH_DIRECTORY'));
}
?>