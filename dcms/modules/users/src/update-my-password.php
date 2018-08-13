<?php
//обновление пароля пользователя
if(!D::$user) {
	D::$tpl->RedirectOrJSON('~/enter/', array('status' => 'UNAUTH'));
}
//старый пароль
$old_password = md5(D::$req->raw('old_password'));
//новый пароль
$new_password1 = md5(D::$req->raw('new_password1'));
//повтор нового паролья
$new_password2 = md5(D::$req->raw('new_password2'));

if($new_password1 == md5('')) {
	D::$tpl->RedirectOrJSON('~/me/new-password-empty/', array('status' => 'EMPTY_PASSWORD'));
}

//сравниваем текущий пароль
if(D::$user->password != $old_password ) {
	D::$tpl->RedirectOrJSON('~/me/old-password-mismatch/', array('status' => 'WRONG_PASSWORD'));
}

//сравниваем что новые пароли вообще совпадают
if($new_password1 != $new_password2) {
	D::$tpl->RedirectOrJSON('~/me/new-password-mismatch/', array('status' => 'PASSWORDS_MISMATCH'));
}
//меняем пароль и сохраняем его
D::$user->password = $new_password1;
D::$user->save();
D::$tpl->RedirectOrJSON("~/me/password-updated/", array('status' => 'OK'));
?>