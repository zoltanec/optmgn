<?php
class Core_I18n_File {


	/**
	 * Get ilist
	 *
	 * @param string $filename - file we want to parse
	 */
	static function getMessagesFromFile($filename) {
		$matches = [];
		preg_match_all('/#([A-Z0-9\_]+)#/',file_get_contents($filename),$matches );
		//теперь обрабатываем найденные сообщения
		$data = "";

		$codes = [];

		foreach($matches[1] AS $code) {
			$codes[] = $code;
		}
		return $codes;
	}

	static function load($filename = '') {
		//массив всех обработанных сообщений
		if(!file_exists($filename)) {
			return false;
		}
		return self::loadI18nMessages(file_get_contents($filename));

	}

	static function loadI18nMessages($data) {
		$messages = array();
		$file = explode("\n", $data);
		//языком по умолчанию считаем английский
		$current_language  = 'en';
		$last_cmd = 0;
		$last_header = '';
		$last_flag = false;
		$string_pool = '';
		$lines = sizeof($file);

		$codes = [];

		$query_values = [];
		for($i = 0; $i <= $lines ; $i++) {
			// empty line, skip it
			$line = (!isset($file[$i]) || !isset($file[$i][0])) ? "  " : $file[$i];

			//команды обработчика начинаются с @
			if($line[0] == '@' or $i  == $lines  ) {
				//похоже новая команда, тогда надо выполнить старую
				if(!empty($string_pool)) {
					$messages[] = array( 'msg_code' => trim($last_header), 'lang' => $current_language, 'msg_text' => trim($string_pool), 'javascript' => $last_flag);
					$string_pool = '';
					$last_flag = false;
					$codes[] = $last_header;
				}
				$last_cmd = $i;
				//команда @@ указывает язык
				if($line[1] == '@') {
					//определяем язык по умолчанию
					$current_language = substr($line, 2,2);
					//префикс ~ говорит о том что текст сообщения необходимо экранировать, чтобы можно было вставить в JavaScript.
				} elseif($line[1] == '~') {
					$last_flag = true;
					$last_header = substr($line, 2);
				} else {
					$last_header = trim(substr($line,1));
				}
			} else {
				// ignore comments in file
				if($line[0]  == '#') {
					continue;
				}
				$string_pool .= $line;
			}
		}

		$query_values = array();
		foreach($messages AS $message) {
			if(  in_array($message['lang'], D::$config->languages)) {
				$query_values[] = "('{$message['msg_code']}','{$message['lang']}','".addslashes($message['msg_text'])."', '{$message['javascript']}' )";
			}
		}

		if(sizeof($query_values) > 0 ) {
			D::$db->exec("INSERT INTO #PX#_core_messages (msg_code,lang,msg_text,javascript) VALUES ".implode(',',$query_values)." ON DUPLICATE KEY UPDATE msg_text = VALUES(msg_text), javascript = VALUES(javascript), upd_time = UNIX_TIMESTAMP()");
		}
		return $codes;
	}
}
?>