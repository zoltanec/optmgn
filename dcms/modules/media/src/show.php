<?php
if(D::$req->isAjax()) {
	$fileid = D::$req->textLine('picture');
	$dirid = D::$req->textID('dirid');
} else {
	if(D::$req->textLine('picture')) {
		$fileid = D::$req->textLine('picture');
		$dirid = D::$req->textID('dirid');
	} else {
		$dirid = D::$req->textID('param1');
		$fileid = D::$req->textID('param2');
	}
}

try {
	//показать файл
	$T['cdir']=$dir = D_Core_Factory::Media_Dir($dirid);
} catch(Exception $e) {
	$dirid=D::$req->textID('dirid');
	D::$Tpl->RedirectOrJSON('~/', array('status' => 'ERROR_NO_SUCH_DIR'));
}
try {
	$file = D_Core_Factory::Media_File($fileid.':::'.$dirid);
	$T['picture']=$file;
} catch (Exception $e) {
	$T['picture']=D::$req->textLine('picture');
	D::$Tpl->RedirectOrJSON('~/ls/dir_'.$dirid, array('status' => 'ERROR_NO_SUCH_FILE'));
}
//$file->UpdateShowCount();
//->UpdateCommentsCount($dirid);
$T['file'] = &$file;

if(D::$req->isAjax() && !D::$req->bool('render_full')) {
	D::$tpl->renderTpl('single-media-object');
}
$T['mode']=D::$req->textLine('mode');
?>