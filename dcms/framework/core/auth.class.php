<?php
class D_Core_Auth {
	static function requireBasicAuth($users = array(), $realm = 'Basic site realm', $password_callback) {
		// проверяем есть ли имя пользователя и пароль
		$username = (isset($_SERVER['PHP_AUTH_USER'])) ? $_SERVER['PHP_AUTH_USER'] : '';
		$password = (isset($_SERVER['PHP_AUTH_PW']))   ? $_SERVER['PHP_AUTH_PW']   : '';
		if(empty($username) || empty($password)) {
			header('WWW-Authenticate: Basic realm="'.$realm.' restricted zone."');
			D::SysExit();

		// если указана функция хэширующая пароль, то передаем в пользовательскую функцию этот пароль и сверяем с тем что в массив, иначе просто сравниваем
		} elseif(isset($users[$username]) && ( is_callable($password_callback) && $password_callback($password) == $users[$username] ) || ($password == $users[$username]) ) {
			header ("HTTP/1.0 200 Ok");
			return $username;
		} else {
			header('WWW-Authenticate: Basic realm="'.$realm.' restricted zone."');
			D::SysExit();
		}
	}
}
?>