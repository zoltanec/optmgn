<?php
//создаем нового юзера
$username = D::$req->textLine('username');
//пароль
$password = D::$req->raw('password');
//запомнить пользователя
$rememberme  = D::$req->bool('rememberme');
try {
	$user = D_Core_Factory::Users_User($username);
} catch (Exception $e) {
	D::$Tpl->RedirectOrJSON("/users/enter/wrong-username/", array('status' => 'NO_SUCH_USERNAME'));
}

//проверяем авторизовало ли пользователя
if(!$user->authorize($password)) {
	D::$Tpl->RedirectOrJSON("/users/enter/wrong-password/", array('status' => 'WRONG_PASSWORD'));
}
//запомнить пользователя надолго
if($rememberme) {
	$user->RememberMe();
} else {
	//сохраняем информацию в сессии
	//@session_start();
	$user->valid=1;
	D::$session[D::$config->users_session_var] = $user;
}

//указываем статистике что пользователь авторизовался
//D::$online_stat->authorized($user->uid);
$url = D::$req->url('return');

if(empty($url)) {
	$url = D::$config->auth_redirect;
}

D::$tpl->RedirectOrJSON($url, array('status' => 'OK', 'username' => $user->username, 'ip' => D::$req->getIP(), 'have_pm' => $user->have_pm));
?>