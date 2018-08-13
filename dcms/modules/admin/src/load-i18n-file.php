<?php
$module = D::$req->textID('module');
$path = D::getModulePath($module);
if($path) {
	if(is_dir($path."/i18n")) {
		$files = scandir($path."/i18n");
		unset($files[0]);
		unset($files[1]);
	}
}
//массив всех обработанных сообщений
$messages = array();
foreach($files AS $lng_file) {
	$file = file($path."/i18n/".$lng_file);
	//языком по умолчанию считаем английский
	$current_language  = 'en';
	$last_cmd = 0;
	$last_header = '';
	$last_flag = false;
	$string_pool = '';
	//обрабатываем все строки в языковом файле
	$lines = sizeof($file);
	for($i = 0; $i <= $lines; $i++) {
		if(isset($file[$i])) {
			$line = $file[$i];
		} else {
			$line = '  ';
		}
		//команды обработчика начинаются с @
		if($line[0] == '@' or $i  == $lines  ) {
			//похоже новая команда, тогда надо выполнить старую
			if(!empty($string_pool)) {
				$messages[] = array('msg_code' => trim($last_header), 'lang' => $current_language, 'msg_text' =>trim($string_pool), 'html' => $last_flag);
				$string_pool = '';
				$last_flag = false;
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
			if($line[0]  == '#') {
				continue;
			}
			$string_pool .= $line;
		}
	}
}
$query_values = array();
foreach($messages AS $message) {
	if(  in_array($message['lang'], D::$config->languages)) {
		$query_values[] = "('{$message['msg_code']}','{$message['lang']}','".addslashes($message['msg_text'])."')";
	}
}
if(sizeof($query_values) > 0 ) {
	D::$db->exec("INSERT INTO #PX#_lng_messages (msg_code,lang,msg_text) VALUES ".implode(',',$query_values)." ON DUPLICATE KEY UPDATE msg_text = VALUES(msg_text)");
}
$T['messages'] = $messages;
if(D::$req->isAjax()) {
	D::$Tpl->PrintText('OK');
}
?>