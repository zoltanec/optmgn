<?php
echo "ID: ".D::$req->textLine('dirid');exit;
try {
	$dir = D_Core_Factory::Media_Dir(D::$req->textID('dirid'));
} catch(Exception $e) {
	D::$Tpl->Redirect('~/');
}
$dir->rebuildDirStat();
D::$Tpl->Redirect('~/ls/dir_'.$dir->dirid);
?>