<?php
class Notify_Mail {
	// robot SMTP address
	private $address = '';
	// message default title
	private $subject = 'Default subject';
	// smtp send host
	private $host = 'smtp.example.com';
	// smtp username
	private $username = 'robot@example.com';
	// password
	private $password = 'example';
	// sign after message
	private $sign = '';
	// smtp port
	private $port = 25;

	static function isValidMail($email) {
		if(empty($email)) return false;

		$email = strtolower($email);
		$split = explode('@', $email);

		if(sizeof($split) != 2 ) return false;

		// check if domain is ok
		if(!checkdnsrr($split[1], 'MX')) return false;

		if(preg_match('/[^a-zA-Z0-9_\-.]/', $split[0])) return false;

		return true;
	}

	/**
	 * Build new email instance
	 */
	function __construct($config) {
		foreach(array('username','password','host','sign') AS $field) {
			if(!isset($config[$field])) throw new D_Core_Exception("Field {$field} is not set");
			$this->{$field} = $config[$field];
		}
		$this->address = ( isset($config['address'])) ? $config['address'] : $this->username;
		$this->port = (isset($config['port'])) ? $config['port'] : $this->port;
	}

	//отсылаем сообщение
	function send($address, $message, $subject, $additions = []) {
		if( !(isset($additions['sign']) && !$additions['sign'] )) {
			$message .= $this->sign;
		}
		error_reporting(E_ERROR);
		require_once ("Mail.php");
		require_once ('Mail/mime.php');
		//создаем новый E-Mail
		$mime = new Mail_mime("\n");
		//указываем текстовое тело сообщения
		$mime->setTXTBody($message);
		$build_params =  array('html_charset'  => 'utf-8','text_charset'  => 'utf-8', 'head_charset'  => 'utf-8');
		$body = $mime->get($build_params);

		$headers_content = ['From'=> $this->address, 'To'=> $address, 'Subject'=>$subject, 'Content-Type'=>'text/plain; charset=UTF-8'];

		foreach($additions AS $key => $value) {
			if(in_array($key, ['Reply-To'])) {
				$headers_content[$key] = $value;
			}
		}

		$headers = $mime->headers($headers_content);
		//формируем сообщение
		$smtp = Mail::factory('smtp', array ('host' => $this->host, 'port' => $this->port, 'auth' => true, 'username' => $this->username,'password' => $this->password ));
		$mail = $smtp->send($address, $headers, $body);
		if(PEAR::isError($mail)) {
			throw new D_Core_Exception($mail->getMessage());
		}
		return true;
	}
}
?>