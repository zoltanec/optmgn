<?php
//хэш от первого пароля
$password1 = D::$req->raw('password1');
//хэш от второго пароля
$password2 = D::$req->raw('password2');
//имя пользователя
$username = D::$req->textLine('username');
$captcha = D::$req->textLine('captcha');
//если пароли совпадают
if( empty($password1) || $password1 != $password2 ) {
	D::$Tpl->RedirectOrJSON("~/start-registration/err_passwords-mismatch/", array('status' => 'ERROR_PASSWORDS_MISMATCH'));
}

if(Users_User::isUsernameExists($username)) {
	D::$Tpl->RedirectOrJSON("~/start-registration/err_user-exists/", array('status' => 'ERROR_USER_EXISTS'));
}

//check captcha
if(!isset(D::$session['captcha_code']) || D::$session['captcha_code'] != $captcha ) {
	D::$Tpl->redirect("~/start-registration/err_wrong-captcha/");
}
//создаем пользователя
$user = new Users_User();
//заносим поля
$user->username = $username;
$user->setPassword($password1);
if(D::$config->users_registration_confirm) {
	$email = D::$req->email('email');
	if(empty($email)) {
		D::$Tpl->RedirectOrJSON('~/start-registration/err_no-email', array('status' => 'ERROR_NO_EMAIL'));
	}
	$user->confirm_code = D_Misc_Random::getString(9);
	$mailer = Core_Mailer::getDefaultMailer();
	$replacements = array('%sitename%' => D::$config->site_name, '%siteaddr%' => D::$config->web, '%username%' => $username, '%code%' => $user->confirm_code, '%validatelink%' => D::$config->web.'/users/confirm-registration/'.$user->confirm_code);
	$mailer->send($email, D::$i18n->getTranslation('USERS_REGISTRATION_EMAIL_HEADER', $replacements), D::$i18n->getTranslation('USERS_REGISTRATION_EMAIL_BODY',$replacements));
	$user->active = 0;
}
$user->valid=1;
$user->save();
if(D::$config->users_registration_confirm) {
	D::$Tpl->RedirectOrJSON('~/wait-for-confirmation/',array('status' => 'WAIT_FOR_CONFIRMATION'));
} else {
	$url = D::$config->auth_redirect;
	//сохраняем данные в сессии
	D::$session[D::$config->users_session_var] = $user;
	D::$Tpl->RedirectOrJSON($url, array('status' => 'OK', 'username' => $username));
}
?>