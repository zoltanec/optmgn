<?php
$dir = D_Core_Factory::Media_Dir(D::$req->textID('dirid'));
if(!$dir) {
	throw new dRuntimeException('NO_SUCH_MEDIA_DIR');
}
$file = D_Core_Factory::Media_File(D::$req->textID('fileid').":::".$dir->dirid);
if(!$file) {
	throw new dRuntimeException('NO_SUCH_MEDIA_FILE');
}
echo $run['webpath'];exit;
if(isset(D::$req->uploaded->files['add_dimension']) AND is_object(D::$req->uploaded->files['add_dimension'])) {
	$uploaded_file = D::$req->uploaded->files['add_dimension'];
	$image = new dImageFile($uploaded_file);
	if(!in_array($image->x.'x'.$image->y, MediaDir::$additional_dimensions)) {
		throw new dRuntimeException('NO_SUCH_DIMENSION');
	}

	//окончание пути
	$path_last = $dir->dirid."/".$image->x."x".$image->y."-".$file->fileid.".".$uploaded_file->getExt();

	$uploaded_file->SaveAs($run['my_content']."/".$path_last);
	$file->AddVariant($image->x."x".$image->y, $run['webpath']."/get-by-dimension/dirid_".$dir->dirid."/fileid_".$file->fileid."/dim_".$image->x."x".$image->y."/ext_".$uploaded_file->getExt()."/");
	$file->save();
}
D::$Tpl->Redirect('~/ls/dir_'.$dir->dirid);
?>