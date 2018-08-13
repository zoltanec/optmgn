<?php
//обновление аватарки пользователя
if(!D::$user) {
	D::$Tpl->RedirectOrJSON('~/enter/',array('status' => 'UNAUTH'));
}
$mode = D::$req->select('mode', array('upload','truncate','set'));
if($mode == 'set') {
	$name = D::$req->textLine('avatar');
} elseif( $mode == 'truncate') {
	$name = '';
} else {
   	if(!isset(D::$req->uploaded->files['avatar']) || !is_object(D::$req->uploaded->files['avatar'])) {
   		echo "error";exit;
   		D::$Tpl->Redirect('~/me/');
   	}
   	$avatar_file = &D::$req->uploaded->files['avatar'];
    switch($avatar_file->type) {
       	case 'image/gif': $ext = ".gif";break;
       	case 'image/png': $ext = ".png";break;
       	case 'image/jpeg': $ext = ".jpg";break;
       	case 'image/jpg': $ext =".jpg"; break;
       	default: D::$Tpl->redirect("~/me/msg_wrong-avatar-type/");
    }
    if($avatar_file->size > $avatar_max_size and $ext == '.gif') {
      	//возвращаемся назад
        D::$Tpl->redirect("~/me/msg_wrong-avatar-size/");
	}
    $name = substr(md5(print_r($_SERVER,true)), 0, 9);
    //если аватарка больше допустимого размера, то мы ее сжимаем сами
    if($avatar_file->size > $avatar_max_size) {
    	//аватарка в виде изображения
        $ava = new dImageFile($avatar_file);
        $name.= ".png";
        $resized = $ava->getPreview(110,180);
        $resized->save(D::$content_path."/users/avatars/".$name);
	} else {
    	$name.=$ext;
		//сохраняем файл
        $avatar_file->saveas(D::$content_path."/users/avatars/".$name);
    }
}
//меняем аватара пользователя
D::$user->avatar = $name;
//сохраняем изменения в пользователе
D::$user->save();
D::$Tpl->RedirectOrJSON("~/me/", array('status' => 'OK'));
?>