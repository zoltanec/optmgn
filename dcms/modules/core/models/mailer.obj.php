<?php
require_once ("Mail.php");
require_once ('Mail/mime.php');
class Core_Mailer {
		// smtp username
		protected $username = '';
		// smtp password
		protected $password = '';
		// smtp remote host ( domain name )
		protected $host = '';
		protected $port = 25;

		function getDefaultMailer() {
			$options = D::$config->mailer;
			if(!$options || empty($options['username']) || empty($options['password']) || empty($options['host'])) {
				throw new D_Core_Exception("No mailer options specified", EX_OTHER_ERROR);
			}
			$port = (isset($options['port'])) ? $options['port'] : 25;

			return new self($options['username'], $options['password'], $options['host'], $port);
		}

		/**
		 *
		 *
		 * @param string $username - smtp username
		 * @param string $password - smtp password
		 * @param string $host -
		 */
		function __construct($username = '', $password = '', $host = '', $port = 25) {
			$this->username = $username;
			$this->password = $password;
			$this->host = $host;
			$this->port = $port;
		}

		function send($to = '', $subject = '', $message = '') {
			//создаем новый E-Mail
    		$mime = new Mail_mime("\n");
    		//указываем текстовое тело сообщения
   		 	$mime->setHTMLBody($message);
   			$build_params =  array('html_charset'  => 'utf-8','text_charset'  => 'utf-8', 'head_charset'  => 'utf-8');
   			$body = $mime->get($build_params);
    		$headers = $mime->headers(array( 'From'=> $this->username, 'To'=> $to, 'Subject' => $subject, 'Content-Type'=>'text/plain; charset=UTF-8'));
			// send message via smtp
    		$smtp = Mail::factory('smtp', array ('host' => $this->host, 'port' => $this->port, 'auth' => true, 'username' => $this->username, 'password' => $this->password));
    		//echo "f";exit;
   			$mail = $smtp->send($to, $headers, $body);
   			return true;
		}
}
?>