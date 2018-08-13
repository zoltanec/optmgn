<?php
//добавление нового каталога
$dirid = D::$req->textID('dirid');
if(!Media_Dir::exists($dirid)) {
    //новый каталог
    $dir = new Media_Dir();
    D::$req->map($dir, array('dirname'=>'textLine','descr'=>'textLine','title'=>'textLine', 'parentid'=>'textID'));
    //идентификатор каталога
    $dir->dirid = $dirid;
    mkdir($run['my_content'].'/'.$dir->dirid);
    mkdir($run['my_content'].'/thumbs/'.$dir->dirid);
    $dir->save();
} else {
	D::$Tpl->RedirectOrJSON('~/', array('status' => 'ERROR_DIR_EXISTS'));
}
D::$Tpl->redirect(D::$req->referer());
?>