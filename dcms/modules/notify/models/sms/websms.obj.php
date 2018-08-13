<?php
class Notify_Sms_WebSMS {
	// имя пользователя websms
	public $username = '';
	// пароль доступа
	public $password = '';
	// адрес API-сервера
	public $api_url = '';

	public function __construct($username = '', $password = '') {
		$this->username = $username;
		$this->password = $password;
	}
	
	public function send($to_raw = 0, $message = '', $from = '') {
		//D_Misc_Url::FetchDocument($this->api_url, array('http_username' => $this->username, 
//'http_password' => $this->password, 'Phone_list'));

		
        $ch = curl_init();
        $url="http://www.websms.ru/http_in5.asp";
        curl_setopt ($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HEADER, 0); 
		curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt ($ch, CURLOPT_POST, 0);
        $post = "http_username={$this->username}&http_password={$this->password}&Phone_list={$to_raw}&Message=".urlencode($message);
        curl_setopt ($ch, CURLOPT_POSTFIELDS, $post);
        curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);
        ob_start ();
        $result = curl_exec ($ch);
        ob_end_clean ();
        curl_close ($ch);
        return $result;
    }
    //уведомление администратора сайта
    static function Admin($message) {
    	self::Send('79226999900', $message);
    }
}
