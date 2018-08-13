<?php
try {
	$dir = D_Core_Factory::Media_Dir(D::$req->dirid);
} catch (Exception $e) {
	D::$Tpl->RedirectOrJSON('~/', array('status' => 'ERROR_NOT_SUCH_MEDIA_DIRECTORY'));
}
if(D::$req->textLine('files') != '') {
	$files = D::$req->textLine('files');
	foreach(explode(';;;', $files) AS $fileid) {
		try {
			$mediafile = D_Core_Factory::Media_File($fileid, $dir->dirid);
		} catch (Exception $e) {
			D::$Tpl->RedirectOrJSON('~/',array('status' => 'ERROR_NO_SUCH_MEDIA_FILE'));
		}
		$mediafile->delete(true);
	}
} else {
	try {
		$mediafile = D_Core_Factory::Media_File(D::$req->textID('fileid'), $dir->dirid);
	} catch (Exception $e) {
		D::$Tpl->RedirectOrJSON('~/',array('status' => 'ERROR_NO_SUCH_MEDIA_FILE'));
	}
	$mediafile->delete(true);
}
$dir->rebuildDirStat();
D::$Tpl->PrintText('OK');
?>