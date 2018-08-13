<?php
//обновление каталога
$dir = D_Core_Factory::Media_Dir(D::$req->textID('dir'));
//выполняем маппинг переменных
D::$req->map($dir,array('descr'=>'textLine','title'=>'textLine','dirname'=>'textLine','parentid'=>'textID', 'active' => 'bool', 'naming'=> 'textLine', 'file_naming'=>'textLine','watermark_enable'=>'bool'));
$preview = D::$req->image('dir_preview');
if( $preview = D::$req->image('dir_preview') ) {
	//выполняем ресайз
	//$preview->cutsize(256,179);
	$preview->save($run['my_content']."/dir_preview/{$dir->dirid}.png",'png');
}
//сохраняем все это дело
$dir->save();
//перенаправляем на страницу каталога
D::$Tpl->redirect(D::$req->referer());
?>