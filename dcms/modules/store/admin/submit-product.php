<?php
$product = new Store_Product();
$prod_code=D::$req->textLine('prod_code');
D::$req->map($product, array('prod_name'=>'textLine','bestseller'=>'int','psc'=>'int','weight'=>'int','producer_id'=>'int','category_id'=>'int','price'=>'int','staff'=>'textLine','descr'=>'textLine','reciple'=>'textLine'));
$product->delivery=1;
$product->rate=0;
$product->save();

Media_Dir::createDir("product".$product->prod_id);
$dir = D_Core_Factory::Media_Dir("product".$product->prod_id);
//найден ли файл
if(isset(D::$req->uploaded->files['mediafile'])) {
	$newFileSource = D::$req->uploaded->files['mediafile'];
	$MediaFile = new Media_File();
	//теперь загружаем
	$MediaFile->parentid($dir->dirid)->from($newFileSource, $newFileSource->getExt())->fileid( $MediaFile->ReplaceToMyMeta( $dir->file_naming) )->filename($MediaFile->ReplaceToMyMeta( $dir->naming) );
	$MediaFile->SaveConverted(D::$content_path.'/media/#parentid#/'.$MediaFile->fileid);
	$MediaFile->instance->GetPreview()->save(D::$content_path.'/media/thumbs/'.$dir->dirid.'/'.$MediaFile->fileid,'jpg',true);
	$MediaFile->save();
}
D::$Tpl->redirect(D::$req->referer());
?>