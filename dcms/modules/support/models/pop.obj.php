<?php
require_once("Net/POP3.php");

class Support_Pop {
	static function getNewMessages() {
		$accounts = D::$config->{'support.emails.logins.pop'};

		$msgs = [];

		foreach($accounts AS $username => $account) {
			$amsgs = [];
			error_reporting(E_ERROR);
			$pop3 = new Net_POP3();
			$pop3->connect($account['server'], $account['port']);
			$pop3->login($username, $account['password']);
			for($x = 1; $x <= $pop3->numMsg(); $x++) {
				$msg = [];
				//var_dump($pop3->getMsg(1));
				$msg['headers'] = self::getReparsedHeaders($pop3->getParsedHeaders($x));
				$msg['headers2'] = $pop3->getParsedHeaders($x);
				$msg['body'] = $pop3->getBody($x);
				$msg['msg'] = $pop3->getMsg($x);
				$pop3->deleteMsg($x);
				$amsgs[] = $msg;
			}
			$msgs[$username] = $amsgs;
			$pop3->disconnect();
		}
		return $msgs;
	}

	static function getVisibleContent($msg) {
		if($msg['headers']['Content-Type-Mode'] == 'multipart/alternative;') {
			return self::getByBoundary($msg['body'], $msg['headers']['Content-Boundary']);
		}

		if(in_array($msg['headers']['Content-Type-Mode'], ['text/plain;','text/html;'])) {

			// fix message encoding to use only UTF-8
			if(!in_array($msg['headers']['Content-Charset'], ['UTF-8'])) {
				$msg['body'] = iconv($msg['headers']['Content-Charset'], 'UTF-8', $msg['body']);
			}
			return $msg['body'];
		}
		return 'WRONG_CONTENT_FORMAT';
	}


	static function getReparsedHeaders($headers) {
		if(!isset($headers['Subject']) || empty($headers['Subject'])) {
			$res['Subject'] = 'No title';
		} else {
			// check subject
			$header = explode('?', $headers['Subject']);

			if(substr($headers['Subject'], 0, 2) == '=?') {
				$res['Subject'] = iconv($header[1], 'utf-8', base64_decode($header[3]));
			} else {
				$res['Subject'] = $headers['Subject'];
			}
		}

		if(!isset($headers['Return-Path']) || empty($headers['Return-Path'])) {
			$res['Return-Path'] = '';
		} else {
			$res['Return-Path'] = str_replace(['<','>'],['',''], $headers['Return-Path']);
			if(!Notify_Mail::isValidMail($res['Return-Path'])) {
				$res['Return-Path'] = '';
			}
		}

		if(isset($headers['Content-Type'])) {
			list($content_type, $enc) = explode(" ", $headers['Content-Type']);
			$res['Content-Type-Mode'] = trim($content_type);

			list($enc_name, $enc_value) = explode("=", $enc);

			if($enc_name == 'charset') {
				$res['Content-Charset'] = trim($enc_value);
			}
			if($enc_name == 'boundary') {
				$res['Content-Boundary'] = trim($enc_value);
			}
		}

		return $res;
	}


	/**
	 * Get objects from message body with specified boundary
	 *
	 * @param unknown_type $data
	 * @param unknown_type $boundary
	 */
	static function getByBoundary($data, $boundary) {
		$objs = explode("--".$boundary, $data);

		//var_dump($objs);
		$best_content = "";

		foreach($objs AS $obj) {
			if(empty($obj)) continue;
			$limit = strpos($obj, "\r\n\r\n");
			if($limit === false) {
				$limit = strpos($obj, "\n\n");
			}

			//echo $obj;

			$headers_raw = substr($obj, 0, $limit);
			$content = substr($obj, $limit + 2);

			$headers = self::getMultipartHeaders($headers_raw);

			//var_dump($headers['Content-Transfer-Encoding']);

			if(isset($headers['Content-Transfer-Encoding']) && $headers['Content-Transfer-Encoding'] == 'base64') {
				$content = base64_decode($content);
			}
			if(isset($headers['Content-Charset']) && $headers['Content-Charset'] != 'UTF-8') {
				$content = iconv($headers['Content-Charset'], 'UTF-8', $content);
			}

			if(empty($best_content) && $headers['Content-Type-Mode'] == 'text/html;' ) {
				$best_content = $content;
			}
			if(isset($headers['Content-Type-Mode']) && $headers['Content-Type-Mode'] == 'text/plain;') {
				$best_content = $content;
			}
		//	var_dump($headers);
			//var_dump($content);
			//echo "BK:";
			//var_dump($best_content);

		}
		return trim($best_content);
	}


	static function getMultipartHeaders($headers) {
		$lines = explode("\n",$headers);
		$parsed_h = [];
		//var_dump($lines);
		foreach($lines AS $line) {
			$line = trim($line);

			if(empty($line)) continue;

			list($name, $value) = explode(":", $line);

			$name = trim($name);
			$value = trim($value);

			$parsed_h[$name] = $value;

			if($name == 'Content-Type') {
				list($content_type, $enc) = explode(" ", $value);
				$parsed_h['Content-Type-Mode'] = $content_type;

				list($enc_name, $enc_value) = explode("=", $enc);

				if($enc_name == 'charset') {
					$parsed_h['Content-Charset'] = $enc_value;
				}
			}

		}
		return $parsed_h;
	}


}

?>