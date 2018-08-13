<?php
class Store_Users extends D_Core_Object{
	use D_Db_ActiveRecord;
	static public $cacheself = 0;
	public $uid = 0;
	//!Имя пользователя
	public $fullname = '';
	//!Адрес проживания пользователя
	public $address = '';
	public $subscribe = 1;
	public $delivery = 0;

	static function __fetch($uid) {
		return self::__fetch_record($uid);
	}

	protected function __save() {
		$user = D::getUser();
		if(!$user) {
			$user = new Users_User();
			$user->username = $this->username;
			$this->phone = $this->username;
			if($this->password==''){
				$this->password=substr(md5(rand()),0,6);
				//Notify_Sms::send($user->username,'Ваш пароль для авторизации на сайте: '.$this->password);
			}
			$user->setPassword($this->password);
			$user->valid=1;
			$user->save();
			D::$session[D::$config->users_session_var] = $user;

		}else{
			$user->username=$this->username;
			if($this->password)
				$user->password=$this->password;
			$user->save();
		}
		return $this->__save_record();
	}


	static protected function __pk() {
		return ['uid'];
	}

	protected function __fields() {
		return ['phone','address','fullname','subscribe'];
	}

	protected function __get_active_orders() {
		return Store_Cart::find(['uid' => $this->uid]);
	}
}
?>
